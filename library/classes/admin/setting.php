<?php 

namespace WPTheme\Admin;

use WPTheme\Theme;
use WPTheme\Admin\Page;


abstract class Setting
{

  /**
   * Setting factory
   * @param  string $name   Name of the setting
   * @param  string $type   Setting type
   * @param  mixed  $value  Setting value
   * @param  array  $config Configuration array
   * @return object         
   */
  public static function factory( string $group, string $name, string $type, array $config = [] )
  {
    $class = '\\WPTheme\\Admin\\Setting\\' . ucfirst($type);

    if( ! class_exists( $class ) )
    {
      wp_die('Setting class not found: ' . $class );
    }

    return new $class( $group, $name, $config );

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
  public $options = [];


  /**
   * Holds error object when error triggered
   * @var [type]
   */
  public $error = FALSE;


  /**
   * Default value
   * @var null
   */
  public $default = NULL;


  /**
   * Setting constructor
   * @param [type] $name   [description]
   * @param array  $config [description]
   */
  public function __construct( string $group, string $name, array $config = array() )
  { 
    // Set type if not specified
    if( empty($this->type) ) $this->type = strtolower(wpt_class_shortname($this));

    // Set settings group
    $this->group = $group;

    // Set the setting name
    $this->name = $name;

     // Set config
    $this->config = $config;

    // Allow set default value
    $this->default = $config['default'] ?? NULL;

    // Set setting label
    $this->label = $config['label'] ?? wpt_labelize($this->name);

    // Set choices
    $this->options = $config['options'] ?? $this->options;

  }


  /**
   * Render the setting
   * @return [type] [description]
   */
  abstract public function render();


  /**
   * Sanitize setting value
   * @param  [type] $value [description]
   * @return [type]        [description]
   */
  abstract public function sanitize( $value );

  /**
   * Validate setting value
   * @return [type] [description]
   */
  abstract public function validate( $value );


  /**
   * Get the setting value
   * @return [type] [description]
   */
  public function value()
  {
    $values = get_option($this->group);

    return $values[$this->name] ?? $this->default;
  }


  /**
   * Is the field required
   * @return [type] [description]
   */
  public function required()
  {
    return in_array('required', $this->config, TRUE);
  }

  /**
   * Get input ID
   * @return [type] [description]
   */
  public function getInputId()
  {
    return 'wpt-settings-' . str_replace('.','-',$this->name);
  }

  /**
   * Get input name
   * @return [type] [description]
   */
  public function getInputName()
  { 
    return $this->group . '[' . str_replace('.','][',$this->name) . ']';
  }

  /**
   * Set an error
   * @param string $message [description]
   * @param string $code    [description]
   */
  public function setError( string $message, string $code = 'setting' )
  {
    $this->error = new \WP_Error( $code, $message );
  }

  /**
   * Get the error
   * @return mixed WP_Error|FALSE
   */
  public function getError()
  {
    return $this->error;
  }

  /**
   * Get error code
   * @return [type] [description]
   */
  public function getErrorCode()
  {
    return $this->error ? $this->error->get_error_code() : FALSE;
  }

  /**
   * Get error message
   * @return [type] [description]
   */
  public function getErrorMessage()
  {
    return $this->error ? $this->error->get_error_message() : FALSE;
  }

 




}