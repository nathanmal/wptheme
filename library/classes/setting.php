<?php 

namespace WPTheme;

use WPTheme\Settings;


class Setting
{

  /**
   * Holds
   * @var array
   */
  protected static $groups = array();


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


  public static function factory( $name, $type, $config )
  {
    $class = '\\WPTheme\\Setting\\' . ucfirst($type);

    if( ! class_exists( $class ) )
    {
      wp_die('Setting class not found: ' . $class );
    }

    return new $class( $name, $config );

  }

  public function __construct( $name, $config = array() )
  { 
    if( empty($this->type) )
    {
      $this->type = strtolower(get_class_shortname($this));
    }

    // Register the setting
    Settings::register($name, $this);

    // Set the setting name
    $this->name = $name;

    // Set the group name. Emtpy string if none
    $this->group = Settings::group($name);

     // Set config
    $this->config = is_array($config) ? $config : array();

    // Allow set default value
    $this->default = element($config, 'default');

    // Set setting label
    $this->label = element( $config, 'label', wpt_labelize($this->name) );

    // Set choices
    $this->choices = element( $config, 'choices', $this->choices );

    // Load value from settings
    $this->value = Settings::get($name, $this->default);

   
  }

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

    if( $this->validate($value) && Settings::update( $this->name, $value ) )
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

  public function render_label()
  {
    echo '<label>' . $this->label .'</label>';

    echo '<small>' . $this->name . '</small>';
  }

  public function render_content()
  {
    echo '[Setting Content]';

    $this->render_note();
  }

  public function render_note()
  {
    $note = element($this->config, 'note');

    if( $note )
    {
      echo '<p class="wpt-setting-note">' . $note .'</p>';
    }
  }

  public function input_id()
  {
    return 'wpt-settings-' . $this->name;
  }


  public function input_name()
  {
    return 'settings[' . $this->name . ']';
  }




  

 




}