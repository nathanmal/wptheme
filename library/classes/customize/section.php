<?php

namespace WPTheme\Customize;

abstract class Section
{

  private $customizer;


  /**
   * Section ID
   * @var string
   */
  public $id = '';


  /**
   * Section title
   * @var string
   */
  public $title = '';


  /**
   * Section config
   * @var array
   */
  public $config = array(
    'priority' => 30
  );


  /**
   * Array of settings
   * @var array
   */
  public $settings = array();

  /**
   * Control instances
   * @var array
   */
  public $controls = array();


  /**
   * Section constructor
   * @param \WPTheme\Customize $customizer [description]
   */
  public function __construct( \WPTheme\Customize $customizer, array $config = array() )
  {
    // Set customizer object
    $this->customizer = $customizer;

    // Apply config
    $this->config = wp_parse_args( $config, $this->config );

    // Ensure ID is set
    if( empty($this->id) )
    {
      $this->id = strtolower( wpt_shortname($this) );
    }

    // Ensure title is set
    if( empty($this->title) )
    {
      $this->title = wpt_shortname($this);
    }

    // Set title in config
    $this->config['title'] = $this->title;

    // Register section
    $this->register();

    // Add section settings
    $this->add_settings();

  }

  /**
   * Register this section with customizer object
   * @return [type] [description]
   */
  public function register()
  {
    $this->customizer->wp->add_section( $this->id, $this->config );
  }

  /**
   * Add a setting to this section
   * @param [type] $id   [description]
   * @param array  $args [description]
   */
  public function add_setting( $id, array $args = array() )
  {
    if( isset($this->settings[$id]) )
    {
      wp_die('Setting already exists <strong>'.$id.'</strong>');
    }

    $this->settings[$id] = $args;

    $this->customizer->wp->add_setting( $id, $args );

  }

  /**
   * Add settings control
   * @param string $id   [description]
   * @param string $type [description]
   * @param array  $args [description]
   */
  public function add_control( string $id, string $type, string $label, array $args = array() )
  {
    // Set section
    if( ! isset($args['section']) )
    $args['section'] = $this->id;

    // Set settings ID
    if( ! isset($args['settings']) )
    $args['settings'] = $id;

    // Set label
    if( ! isset($args['label']) )
    $args['label'] = $label;

    // Set control
    if( ! isset($args['type']) )
    $args['type'] = $type;


    $this->customizer->wp->add_control( $this->control($id, $type, $args), $args );


    // Get control object
    // $this->controls[$id] = $this->get_control( $type, $id, $args );

    // Add to customizer
    // $this->customizer->wp->add_control( $this->controls[$id] );
  }




  /**
   * Get control instance
   * @param  string $type [description]
   * @param  string $id   [description]
   * @param  array  $args [description]
   * @return [type]       [description]
   */
  public function control( string $id, string $type, array $args = array() )
  {

    $control = NULL;

    switch($type)
    {
      case 'integer':

        $args['type'] = 'number';

        if( isset($args['input_attrs']) )
        {
          if( ! isset($args['input_attrs']['min']) )
          {
            $args['input_attrs']['min'] = 0;
          }
          
          $args['input_attrs']['step'] = 1;
        }
        else
        {
          $args['input_attrs'] = array('min'=>0,'step'=>1);
        }
        
        $control = new \WP_Customize_Control( $this->customizer->wp, $id, $args );

        break;

      case 'color':

        $control = new \WP_Customize_Color_Control( $this->customizer->wp, $id, $args );
        break;

      case 'color_alpha':

        $control = new \WPTheme\Customize\Control\Coloralpha( $this->customizer->wp, $id, $args );
        break;

      case 'image':

        $control = new \WP_Customize_Image_Control( $this->customizer->wp, $id, $args );
        break;


      case 'slider':

        $control = new \WPTheme\Customize\Control\Slider( $this->customizer->wp, $id, $args );
        break;

      default:

        $control = $id;
        break;
    }

    return $control;


  }



  public function get_css()
  {
    return '';
  }


  /**
   * Add settings. This should be overridden
   */
  abstract public function add_settings();






}