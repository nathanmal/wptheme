<?php 

namespace WPTheme;

use \WPTheme\Package;

class Settings
{

  protected static $page = '';

  public static function get( $key, $default = FALSE )
  {
    $key = 'wpt_' . $key;

    return get_option( $key, $default );
  }

  public static function update( $key, $value )
  {
    $key = 'wpt_' . $key;

    return update_option( $key, $value );
  }

  public static function _render()
  {

    Settings::$page = element($_GET, 'page', 'wptheme');

   



    $settings = new Settings();

    // Page wrapper
    echo '<div id="wpt-settings" class="wrap">';
    
    // Main Form
    echo '<form action="' . Settings::url(Settings::$page) . '" method="post">';
    
    echo '<div class="wpt-settings-title">';
    echo '<i class="fas fa-cog"></i>';
    echo '<h1>' . $settings->get_title() . '</h1>';
    echo '</div>';


    // Render the page
    $settings->render();


    submit_button( 'Save Settings' );

    // Closing tags
    echo '</form>';

    echo '</div>';


    if( ! empty($_POST) ) pre($_POST);
   
  }

  public static function url( $page = 'wptheme' )
  {
    return admin_url('admin.php?page=wptheme');
  }



  public function __construct()
  {
    if( empty($this->title) )
    {
      $this->title = get_class_shortname($this);
    }
  }



  public function render()
  {

    $types = get_post_types();

    ?>
    
    <section id="wpt-assets">
    <h1>Assets</h1>
    <?php $this->do_setting('assets_use_cdn','boolean', array('label'=>'Use CDN')); ?>
    </section>

    <section id="wpt-packages">
    <h1>Packages</h1>
    <p>Include these packages</p>
    <?php 

    $all = Package::all();

    foreach($all as $name => $package)
    {
      $setting = 'assets_package_' . $name;
      $version = element($package,'version','');
      $label   = element($package,'title',ucwords($name)) . ' ' . $version;

      $this->do_setting( $setting,'boolean', array('label'=>$label));
    }

    ?>



    </section>


    <section id="wpt-integrations">
      <h1>Integrations</h1>

      <?php
      $this->do_setting( 'google_maps_key','text', array('label'=>'Google Maps API Key'));

      $this->do_setting( 'google_maps_center', 'text' );

      $this->do_setting( 'google_maps_style','textarea');



      $this->do_setting( 'google_analytics_ua','text', array('label'=>'Google Analytics Code','note'=>'UA-XXXXXXX'));

      ?>
    </section>


    <section id="wpt-fonts">
    <h1>Fonts</h1>
    </section>


  

    <?php

  }


  public function get_title()
  {
    return $this->title;
  }

  public function do_setting( $name, $type, $config = array() )
  {
    // Default value
    $default = element($config, 'default');

    // Label
    $label = element($config, 'label', $name);

    // Get stored value
    $value = Settings::get($name, $default);


    $input = element( $_POST, $name, $default );

    if( isset($_POST[$name]) && $_POST[$name] != $value  )
    {
      $updated = Settings::update($name, $input);

      if($updated)
      {
        $value = $input;
      }
    }

    echo '<div class="wpt-setting-row">';

    echo '<div class="wpt-setting-label">';
    echo '<label for="">'.$label.'</label>';
    echo '<small>'.$name.'</small>';
    echo '</div>';

    echo '<div class="wpt-setting wpt-setting-' . $type .'">';

    switch($type)
    {

      case 'image':

        wp_enqueue_media();

        ?>
        <div class="wpt-setting-image-wrapper">
          <a href="#" class="wpt-setting-image-upload">
            <span class="dashicons dashicons-format-image"></span>
          </a>
          <a href="#" class="wpt-setting-image-delete">
            <span class="dashicons dashicons-trash"></span>
          </a>
        </div>
        <input type="hidden" name="<?= $name ?>" value="">

        <div class="wpt-setting-image-wrapper wpt-setting-image-wrapper-mobile">
          <a href="#" class="wpt-setting-image-upload">
            <span class="dashicons dashicons-format-image"></span>
          </a>
          <a href="#" class="wpt-setting-image-delete">
            <span class="dashicons dashicons-trash"></span>
          </a>
        </div>
        <input type="hidden" name="<?= $name ?>" value="">

        <?php

        break;



      case 'boolean':

        if( ! empty($_POST) ) 
        {
          $value = isset($_POST[$name]);
          Settings::update($name, $value);
        }
        
        $checked = !! $value ? 'checked' : '';

        echo '<input name="'.$name.'" type="checkbox" value="1" '.$checked.' />';
        break;

      case 'textarea':

        echo '<textarea name="'.$name.'" class="widefat" rows="12">' . $value .'</textarea>';
        break;

      case 'text':
      default:
        echo '<input name="'.$name.'" type="text" value="' . $value . '" />';
        break;
    }

    // End Setting
    echo '</div>';
    
    // End Row
    echo '</div>';


  }

}