<?php 

namespace WPTheme;

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


     pre($_POST);
   
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

   
    ?>
    
    <section id="wpt-assets">
    <h1>Assets</h1>
  
    <?php 
    $this->do_setting('assets_use_cdn','boolean', array('label'=>'Use CDN'));
    ?>


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

      case 'boolean':

        if( ! empty($_POST) ) 
        {
          $value = isset($_POST[$name]);
          Settings::update($name, $value);
        }
        
        $checked = !! $value ? 'checked' : '';

        echo '<input name="'.$name.'" type="checkbox" value="1" '.$checked.'>';
        break;

      case 'text':
      default:
        echo '<input name="'.$name.'" type="text" value="' . $value . '" />';
        break;
    }

    echo '</div>';
    


  }

}