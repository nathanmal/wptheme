<?php
/**
 * Settings page class
 *
 * 
 */

namespace WPTheme\Admin;


class Page
{

  /**
   * Is settings page enabled
   * @var boolean
   */
  public $enabled = TRUE;

  /**
   * Settings page title
   * @var string
   */
  public $title = '';

  /**
   * Settings menu title
   * @var string
   */
  public $menu_title = '';

  /**
   * Settings page slug
   * @var string
   */
  public $slug = '';

  /**
   * Capability needed to view/use this page
   * @var string
   */
  public $capability = 'manage_options';


  /**
   * Setting sections
   * @var array
   */
  protected $sections = array();

  /**
   * Settings
   * @var array
   */
  protected $settings = array();

  /**
   * Loaded settings values
   * @var array
   */
  protected $values = array();


  /**
   * Settings page constructor
   *
   * Sets up important variables
   * 
   */
  public function __construct()
  { 
    if( empty($this->slug) ) $this->slug = strtolower(wpt_class_shortname($this));

    $this->slug = wpt_prefix( $this->slug, 'wptheme_' );

    add_action( 'admin_init', [$this, 'init']);
  }


  /**
   * Settings page init
   * @return [type] [description]
   */
  public function init()
  {
    register_setting( $this->slug, $this->slug, [$this, 'sanitize']);

    $this->values = get_option($this->slug);

    $this->register_settings();

  }


  /**
   * Get the settings page slug
   * @return [type] [description]
   */
  public function getSlug()
  {
    return $this->slug;
  }


  

  /**
   * Sanitize field
   * @param  [type] $input [description]
   * @return [type]        [description]
   */
  public function sanitize( $input )
  {

    $new_input = array();

    foreach($input as $id => $value)
    {
      $setting = $this->getSetting($id);

      $value = $setting->sanitize($value);

      if( $setting->validate($value) )
      {
        $new_input[$id] = $value;
      }
      else
      {
        add_settings_error( $id, $setting->getErrorCode(), $setting->getErrorMessage(), $type = 'error' );
        return FALSE;
      }
    }

    return $new_input;
  }


  /**
   * Get setting object
   * @param  string $id [description]
   * @return [type]     [description]
   */
  public function getSetting( string $id )
  {
    $title  = $this->settings[$id]['title'];
    $type   = $this->settings[$id]['type'];
    $config = $this->settings[$id]['config'] ?? [];

    return Setting::factory( $this->slug, $id, $type, $config );
  }


  public function process()
  {
    // Settings group must be set
    if( empty($this->group) )
    {
      wp_die('Settings page group not set');
    }

    // Get values
    $this->values = wpt()->option->group($this->group);

    // Register page settings
    $this->register_settings();

    // Check for form submission
    if( isset($_POST['settings']) && isset($_POST['submit']) )
    {
      $this->input = $_POST['settings'];

      $this->save();
    }

    
  }

  /**
   * Render the settings page
   * @return [type] [description]
   */
  public function render_page()
  {
    ?>
    <div id="wpt-settings" class="wrap">
      <h1>My Settings</h1>
      <form method="post" action="options.php">
      <?php
        // This prints out all hidden setting fields
        settings_fields( $this->slug );
        do_settings_sections( $this->slug );
        submit_button();
      ?>
      </form>
    </div>
    <?php
  }


  /**
   * Register page settings
   * @return [type] [description]
   */
  public function register_settings()
  {

  }



  /**
   * Register settings section
   * @param  string $id    [description]
   * @param  string $title [description]
   * @param  string $info  [description]
   * @return [type]        [description]
   */
  public function register_section( string $id, string $title, string $info = '' )
  { 
    $this->sections[$id] = array(
      'title' => $title,
      'info' => $info
    );


    add_settings_section( $id, $title, [$this, 'settings_info'], $this->slug);
  }

  /**
   * Register a setting
   * @param  string $id      [description]
   * @param  string $title   [description]
   * @param  string $type    [description]
   * @param  string $section [description]
   * @return [type]          [description]
   */
  public function register_setting( string $id, string $title, string $type, string $section_id, array $config = [] )
  {
    $this->settings[$id] = array(
      'title' => $title,
      'type' => $type,
      'section' => $section_id,
      'config' => $config
    );

    add_settings_field( 
      $id, 
      $title, 
      [$this, 'render_setting'], 
      $this->slug, $section_id, 
      ['id'=>$id, 'config'=>$config]
    );
  }

  /**
   * Render settings section info
   * @param  array  $args [description]
   * @return [type]       [description]
   */
  public function settings_info( array $args )
  {
    echo $this->sections[$args['id']]['info'];
  }

  /**
   * Render setting
   * @param  array  $args [description]
   * @return [type]       [description]
   */
  public function render_setting( array $args )
  {
    $id = $args['id'];
    
    $setting = $this->getSetting($id);

    $setting->render();

  }











  /**
   * Register a setting for this page
   * @param  string $name   [description]
   * @param  string $type   [description]
   * @param  array  $config [description]
   * @return [type]         [description]
   */
  public function register_setting_old( string $name, string $type, array $config = array() )
  {
    if( isset( $this->settings[$name]) )
    {
      wp_die('Setting already registered: ' . $name);
    }

    // Get value from settings group
    $value = element($this->values, $name);

    // Create the setting object
    $this->settings[$name] = Setting::factory($name, $type, $value, $config);
  }


  /**
   * Save registered settings
   * @return [type] [description]
   */
  public function save()
  {
    foreach( $this->settings as $name => $setting )
    {
      $input_value = $this->input[$name] ?? NULL;

    }
  }

  /**
   * Render settings page
   * @return [type] [description]
   */
  public function render()
  {

  }


}