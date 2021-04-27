<?php

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
   * Settings post input array
   * @var array
   */
  public $input = array();

  /**
   * Array of registered settings
   * @var array
   */
  public $settings = array();


  /**
   * Loaded settings values
   * @var array
   */
  public $values = array();


  /**
   * The options group
   * @var string
   */
  public $group = '';

  /**
   * Settings page constructor
   *
   * Sets up important variables
   * 
   */
  public function __construct()
  {
    if( empty($this->slug) ) $this->slug = strtolower(wpt_shortname($this));
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
   * Register page settings
   * @return [type] [description]
   */
  public function register_settings()
  {

  }

  /**
   * Register a setting for this page
   * @param  string $name   [description]
   * @param  string $type   [description]
   * @param  array  $config [description]
   * @return [type]         [description]
   */
  public function register_setting( string $name, string $type, array $config = array() )
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