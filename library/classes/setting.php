<?php 

namespace WPTheme;

use WPTheme\Theme;
use WPTheme\Admin\Page;


class Setting
{

  /**
   * Holds data loaded from options table
   * @var array
   */
  protected static $cache = array();

  /**
   * Holds registered settings
   * @var array
   */
  protected static $registered = array();

  /**
   * Holds
   * @var array
   */
  protected static $groups = array();




  /**
   * Setting factory method
   * @param  [type] $name   [description]
   * @param  [type] $type   [description]
   * @param  [type] $config [description]
   * @return [type]         [description]
   */
  public static function factory( $name, $type, $config )
  {
    $class = '\\WPTheme\\Setting\\' . ucfirst($type);

    if( ! class_exists( $class ) )
    {
      wp_die('Setting class not found: ' . $class );
    }

    return new $class( $name, $config );

  }


  /**
   * Register a setting
   * @param  [type] $key     [description]
   * @param  [type] $setting [description]
   * @return [type]          [description]
   */
  public static function register( $key, $setting )
  {
    if( isset(Setting::$registered[$key]) ) 
    {
      Theme::error('Setting is already registered: ' . $key);
      return FALSE;
    }

    if( empty($setting) OR ! is_a($setting, '\\WPTheme\\Setting') )
    {
      Theme::error('Setting must be instance of WPTheme\\Setting class');
      return FALSE;
    }

    Setting::$registered[$key] = $setting;

    return TRUE;
  }


  /**
   * Get a setting value
   * @param  [type]  $key     [description]
   * @param  boolean $default [description]
   * @return [type]           [description]
   */
  public static function get( $key, $default = FALSE, $refresh = FALSE )
  { 
    // Cache values
    if( ! isset(Setting::$cache[$key]) OR $refresh )
    {
      Setting::$cache[$key] = get_option('wpt.'.$key, $default );
    }

    return Setting::$cache[$key];
  }


  /**
   * Update a setting value
   * 
   * @param  [type] $key   [description]
   * @param  [type] $value [description]
   * @return [type]        [description]
   */
  public static function set( $key, $value )
  {
    // Update the option and if successful, the cache
    if( update_option( 'wpt.' . $key , $value ) )
    {
      Setting::$cache[$key] = $value;

      return TRUE;
    }

    return FALSE;
  }



  /**
   * Setting name
   * @var string
   */
  public $name = '';


  /**
   * Setting group
   * @var [type]
   */
  public $group = ''; 

  /**
   * Setting label
   * @var string
   */
  public $label = '';

  /**
   * Choices for select/radio etc
   *
   * Must be value => label
   * @var array
   */
  public $choices = array();

  /**
   * Setting value
   * @var [type]
   */
  public $value;  

  /**
   * Holds last error message
   * @var [type]
   */
  public $error = '';


  /**
   * Setting constructor
   * @param [type] $name   [description]
   * @param array  $config [description]
   */
  public function __construct( $name, $config = array() )
  { 
    if( empty($this->type) )
    {
      $this->type = strtolower(get_class_shortname($this));
    }

    // Auto register this setting
    Setting::register($name, $this);

    // Set config
    $this->config = is_array($config) ? $config : array();

    // Set the setting name
    $this->name = $name;

    // Set the group name. Emtpy string if none
    $this->group = element($config, 'group', 'default');

    // Allow set default value
    $this->default = element($config, 'default');

    // Set setting label
    $this->label = element( $config, 'label', wpt_labelize($this->name) );

    // Set choices
    $this->choices = element( $config, 'choices', $this->choices );

    // Load value from settings
    $this->value = Setting::get($name, $this->default);
  }


  /**
   * Render the setting
   * @return [type] [description]
   */
  public function render()
  {
    echo '<div class="wpt-setting wpt-setting-type-' . $this->type .'">';

    echo '<div class="wpt-setting-label">';

    $this->render_label();

    echo '</div>';

    echo '<div class="wpt-setting-content">';

    $this->render_content();

    $this->render_note();

    echo '</div>';

    echo '</div>';
  }


  /**
   * Update the setting to provided value
   *
   * sanitizes/validates value before updating
   *  
   * @param  [type] $value [description]
   * @return [type]        [description]
   */
  public function update( $value = NULL )
  {
    $value = $this->sanitize($value);

    if( $this->validate($value) && Setting::set( $this->name, $value ) )
    {
      $this->value = $value;
      
      return TRUE;
    }

    return FALSE;

  }

  /**
   * Sanitize setting value
   * @param  [type] $value [description]
   * @return [type]        [description]
   */
  public function sanitize( $value )
  {
    return $value;
  }

  /**
   * Validate setting value
   * @return [type] [description]
   */
  public function validate()
  {
    return TRUE;
  }

  /**
   * Render the setting label
   * @return [type] [description]
   */
  public function render_label()
  {
    echo '<label>' . $this->label .'</label>';

    echo '<small>' . $this->name . '</small>';
  }

  /**
   * Render the setting content
   * @return [type] [description]
   */
  public function render_content()
  {
    echo '[Setting Content]';

    $this->render_note();
  }

  /**
   * Render note
   * @return [type] [description]
   */
  public function render_note()
  {
    $note = element($this->config, 'note');

    if( $note )
    {
      echo '<p class="wpt-setting-note">' . $note .'</p>';
    }
  }

  /**
   * Get input ID
   * @return [type] [description]
   */
  public function input_id()
  {
    return 'wpt-settings-' . str_replace('.','-',$this->name);
  }

  /**
   * Get input name
   * @return [type] [description]
   */
  public function input_name()
  {
    return 'settings[' . $this->name . ']';
  }




  

 




}