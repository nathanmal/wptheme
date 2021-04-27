<?php 

namespace WPTheme;

use WPTheme\Theme;
use WPTheme\Admin\Page;


class Setting
{

  /**
   * Setting factory
   * @param  string $name   Name of the setting
   * @param  string $type   Setting type
   * @param  mixed  $value  Setting value
   * @param  array  $config Configuration array
   * @return object         
   */
  public static function factory( string $name, string $type, mixed $value, array $config )
  {
    $class = '\\WPTheme\\Setting\\' . ucfirst($type);

    if( ! class_exists( $class ) )
    {
      wp_die('Setting class not found: ' . $class );
    }

    return new $class( $name, $config );

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
   * @var array
   */
  public $options = array();

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
  public function __construct( string $name, mixed $value = NULL, array $config = array() )
  { 
    // Set type if not specified
    if( empty($this->type) ) $this->type = strtolower(wpt_shortname($this));

    // Auto register this setting
    Setting::register($name, $this);

    // Set config
    $this->config = $config;

    // Set the setting name
    $this->name = $name;

    // Allow set default value
    $this->default = element($config, 'default');

    // Set setting label
    $this->label = element( $config, 'label', wpt_labelize($this->name) );

    // Set choices
    $this->options = element( $config, 'options', $this->options );

    // Load value from settings
    $this->value = $value;
  }


  /**
   * Render the setting
   * @return [type] [description]
   */
  public function render()
  {
    echo '<div class="wpt-setting wpt-setting-type-' . $this->type .'">';
    
    echo '<div class="wpt-setting-label">';

    // Render the label
    $this->render_label();

    echo '</div>';

    echo '<div class="wpt-setting-content">';

    // Render the input
    $this->render_input();

    // Render the footer
    $this->render_footer();

    echo '</div>';

    echo '</div>';
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
  public function validate( $value )
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
    $this->render_input();

    $this->render_footer();
  }

  /**
   * Render note
   * @return [type] [description]
   */
  public function render_footer()
  {
    if( ! empty($this->error) )
    {
      echo '<p class="wpt-setting-error">' . $this->error .'</p>';

      return;
    }

    if( $description = element($this->config, 'description') )
    {
      echo '<p class="wpt-setting-description">' . $description .'</p>';
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
    return 'settings[' . str_replace('.','][',$this->name) . ']';
  }

  /**
   * Set an error
   * @param  string $msg [description]
   * @return [type]      [description]
   */
  public function error( string $msg )
  {
    $this->error = $msg;
  }

  /**
   * Get last error
   * @return [type] [description]
   */
  public function getError()
  {
    return $this->error;
  }
  

 




}