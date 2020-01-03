<?php 

namespace WPTheme\Settings;

use WPTheme\Settings;
use WPTheme\Setting;
use WPTheme\Package;
use WPTheme\Font;

class Assets extends Settings
{
  public function setup()
  {
    if( $package = element($_GET, 'add_package') )
    {
      if( Package::import($package) )
      {
        Settings::notice('Package installed: ' . $package,'success', TRUE);
      }
      else
      {
        Settings::notice( Package::error() ,'error', TRUE);
      }
    }


    if( $package = element($_GET, 'remove_package') )
    {
      if( Package::remove($package) )
      {
        Settings::notice('Package removed: ' . $package,'success', TRUE);
      }
      else
      {
        Settings::notice( Package::error() ,'error', TRUE);
      }
    }


    if( $font = element($_GET, 'add_font') )
    {
      if( Font::install(urldecode($font)) )
      {
        Settings::notice('Font installed: ' . $font,'success', TRUE);
      }
      else
      {
        Settings::notice( Font::error(), 'error', TRUE);
      }
    }

    if( $font = element($_GET, 'remove_font') )
    {
      if( Font::remove(urldecode($font)) )
      {
        Settings::notice('Font removed: ' . $font,'success', TRUE);
      }
      else
      {
        Settings::notice( Font::error(), 'error', TRUE);
      }
    }
  }


  public function add_meta_boxes()
  {
    add_meta_box(
        'wpt-packages',                       /* Meta Box ID */
        'Packages',                   /* Title */
        array($this,'metabox_packages'),  /* Function Callback */
        Settings::$screen,                    /* Screen: Our Settings Page */
        'normal',                             /* Context */
        'high'                                /* Priority */
    );


    add_meta_box(
        'wpt-fonts',                       /* Meta Box ID */
        'Install Fonts',                   /* Title */
        array($this,'metabox_fonts'),  /* Function Callback */
        Settings::$screen,                    /* Screen: Our Settings Page */
        'normal',                             /* Context */
        'high'                                /* Priority */
    );
  }


  public function metabox_packages()
  {
   

    $config = array(
      'choices' => array(
        'local' => 'Local',
        'cdn'   => 'CDN'
      ),
      'note' => 'Whether to use CDN or Local version of packages'
    );

    $this->do_setting('package.source','radio','Package Source', $config); 


    $this->do_setting('packages.installed', 'packages', 'Installed Packages' );

  }


  public function metabox_fonts()
  {

    $config = array(
      'note' => 'API key is required to install google fonts'
    );

    $this->do_setting('fonts.google.apikey','text','Google Fonts API Key', $config);

    $key = Settings::get('fonts.google.apikey');

    if( ! empty($key) )
    {
      $config = array('apikey'=>$key);

      $this->do_setting('fonts.installed', 'googlefonts', 'Google Fonts', $config);

    }

    
  }

  public function render()
  {


    ?>
   

    <section id="wpt-packages">
    <h1>Packages</h1>
        <?php 

    $config = array(
      'choices' => array(
        'local' => 'Local',
        'cdn'   => 'CDN'
      ),
      'note' => 'Whether to use CDN or Local version of packages'
    );

    $this->do_setting('package.source','radio','Package Source', $config); 

    ?>
    
    <hr/>

    <h2>Install Packages</h2>
    <br/>
    
    <div class="wpt-search-package">
      <input id="wpt-package-search" type="text" placeholder="Search Packges" />
      <div id="wpt-package-search-results"></div>
    </div>
    
    
    <?php 

    $config = array('render_input'=>array(__CLASS__, 'render_packages'));

    if( isset($_GET['package']) )
    {
      $package = element($_GET, 'package');
      $action  = element($_GET, 'action');

      switch($action)
      {
        case 'add':

          $imported = Package::import($package);

          pre($imported);
          break;

        case 'remove':
          break;

        default:
          break;
      }


    }

    $imported = Settings::get('packages.imported', array() );

    // Update if posted
    if( Settings::$updating && $packages = Settings::input('packages') )
    {
      foreach( $packages as $name => $input )
      {
        if( isset($imported[$name]) )
        {
          $imported[$name]['enabled']  = !! isset($input['enabled']);
          $imported[$name]['includes'] = array_unique(element($input, 'includes', array()));
        }
      }

      if( Settings::update('packages.imported', $imported ) )
      {
        Settings::notice('Packages Updated!','success');
      }
    }


    echo '<div class="wpt-packages-imported">';

    foreach( $imported as $name => $package ) 
    {

      $includes = element($package,'includes',array());
      $files    = element($package,'files',array());


      $arr = 'settings[packages][' . $name . ']';

      $enabled = element($package,'enabled') ? 'wpt-package-enabled' : 'wpt-package-disabled';

      ?>
      <div class="wpt-package <?=$enabled?>" data-name="<?=$name?>">
        <div class="wpt-package-header">
          <span class="wpt-package-title">
            <label>
              <input name="<?= $arr ?>[enabled]" type="checkbox" value="1" <?= element($package,'enabled') ? 'checked' :'' ?>/>
              <?= $name ?>
            </label>
          </span>
          <span class="wpt-package-version"><?= element($package,'version','') ?> <?= element($package,'latest') ? '(latest)' : '' ?></span>
          <span class="wpt-package-description"><?= $package['info']->description ?></span>
          <a href="#" class="wpt-package-files-toggle"><?= count($includes) . '/' . count($files) ?> included</a>
        </div>
        
        <div class="wpt-package-files-wrapper">
          <ul class="wpt-package-files">
          <?php foreach($files as $index => $file) { 
            $class = 'wpt-package-file' . (in_array($index, $includes) ? ' wpt-package-file-selected' : '');
            ?>
            <li class="<?= $class ?>" data-index="<?= $index ?>">
              <?= $file ?>
            </li>
          <?php } ?>
          </ul>
        </div>

        
        
        <ul class="wpt-package-includes">
          <?php foreach($includes as $index) { ?>
            <li class="wpt-package-file" data-index="<?=$index?>">
              <?= $files[$index] ?>
              <input type="hidden" name="<?=$arr?>[includes][]" value="<?=$index?>" />
            </li>
          <?php } ?>
        </ul>

        

      </div>
      <?php 
    }

    ?>


    <?php 

    /*
    $all = Package::all();

    foreach($all as $name => $package)
    {
      $setting = 'packages.' . $name;
      $version = element($package,'version','');
      $label   = element($package,'title',ucwords($name)) . ' ' . $version;

      $this->do_setting( $setting, 'boolean', $label );
    }

    */

    ?>



    </section>


    <section id="wpt-fonts">
    <h1>Fonts</h1>
    
    
    <?php 

    $this->do_setting('google.fonts.apikey','text','Google Fonts API Key');

    $fonts = Settings::get('google.fonts.imported', array());


    if( isset($_GET['font']) )
    {
      $family = urldecode(element($_GET, 'font'));
      $action  = element($_GET, 'action');

      switch($action)
      {
        case 'add':

          $imported = $this->install_font($family);
          break;

        default:
          break;
      }
    }


    $installed = Settings::get('fonts.installed');

    ?>
    
    <button class="button button-primary" id="wpt-font-add" type="button">Install Fonts</button>

    
    
    <div class="wpt-fonts-installed">
      <?php 
      foreach($installed as $font)
      {
        ?> 
        <div class="wpt-font">
          <h3><?= $font->family ?></h3>
          <span class="wpt-font-variants">
            <?php 
            foreach($font->variants as $variant)
            {
              $id = 'wpt-font-' . strtolower(str_replace(' ','-',$font->family)) . '-'.$variant;
              ?> 
              <label for="<?=$id?>">
                <?= $variant ?>
                <input id="<?=$id?>" type="checkbox" name="settings[fonts][<?=$font->family?>][<?=$variant?>]" value="<?=$variant?>"/>
              </label>
              <?php 
            }
            ?>

          </span>
        </div>

        <?php 
      }
    

    ?>


    </div>
    


    </section>

    <?php 

  }

  private function install_font($family)
  {
    $installed = Settings::get('fonts.installed', array() );

    if( isset($installed[$family]) ) return;

    $key = Settings::get('fonts.google.apikey');

    $url = 'https://www.googleapis.com/webfonts/v1/webfonts?key='.$key;

    $json = file_get_contents($url);

    $data = json_decode($json);

    foreach($data->items as $item)
    {
      if( $item->family == $family )
      {
        $installed[$family] = $item;
      }
    }

    return Settings::update('fonts.installed', $installed);
  }

  private function render_packages( $setting )
  {
    pre($setting);
  }

}