<?php

namespace WPTheme;


class Customize
{

  /**
   * Customize singleton
   * @var [type]
   */
  private static $instance;


  /**
   * Registered sections
   * @var array
   */
  public $sections = array();


  /**
   * Initialize singleton
   * @param  [type] $wp_customize [description]
   * @return [type]               [description]
   */
  public static function init( $wp_customize )
  {
    new Customize($wp_customize);
  }


 


  /**
   * Customize constructor
   * @param [type] $wp_customize [description]
   */
  public function __construct( $wp_customize )
  {
    // Wordpress customizer object
    $this->wp = $wp_customize;

    // Register custom panels
    $this->register_panels();

    // Register custom sections
    $this->register_sections();

    // Hook when mod option is updated
    add_action( 'updated_option', array( $this, 'update_option' ), 10, 1 );

    // Hook when preview pane is refreshed
    add_action( 'customize_preview_init', array( $this, 'preview_init'), 10, 1);

    // Enqueue custom control scripts
    // add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_controls') );

  }



  public function register_panels()
  {

  }


  /**
   * Register theme customizer sections
   * @return [type] [description]
   */
  public function register_sections()
  { 

    $this->register_section('background');
    $this->register_section('header');

    /*
    $this->wp->add_section( 'background', array(
      'title' => 'Background',
      'priority' => 30
    ));

    $this->wp->add_setting( 'background_color', array(
      'default' => '#FFFFFF',
      'transport' => 'refresh'
    ));


    $config = array(
      'label' => 'Background Color',
      'section' => 'background',
      'settings' => 'background_color'
    );


    $this->wp->add_control( new \WP_Customize_Color_Control( $this->wp, 'background_color', $config) );
    */
    
    /*
    $mods = get_theme_mods(); 
    pre($mods);
    exit();
    */
   
  }



  public function register_section($id)
  {
    // Check for existing section
    if( isset($this->sections[$id]) )
    {
      wp_die('Section already exists <strong>'.$id.'</strong>');
    }

    // Get class name
    $class = 'WPTheme\\Customize\\Section\\' . ucfirst($id);

    // Attempt to load class
    if( ! class_exists($class) )
    {
      wp_die('Could not locate section <strong>'.$class.'</strong>');
    }

    // Instantiate
    $this->sections[$id] = new $class($this);

  }


  public function enqueue_controls()
  {
    // Enqueue customizer script
    wp_enqueue_script(
      'wptheme-customizer-controls', 
      get_template_directory_uri() . '/assets/dist/controls.js',
      array('jquery'),
      '',
      TRUE
    );

    // Enqueue control styles
    wp_enqueue_style(
      'wptheme-customizer-controls',
      get_template_directory_uri() . '/assets/dist/controls.css'
    );
  }


  public function enqueue_customizer()
  {
    // Enqueue customizer script
    wp_enqueue_script(
      'wptheme-customizer', 
      get_template_directory_uri() . '/assets/dist/customize.js',
      array('customize-preview','jquery'),
      '',
      TRUE
    );

    $uploads = wp_get_upload_dir();

    // Enqueue customized styles
    wp_enqueue_style(
      'wptheme-customized', 
      $uploads['baseurl'] . '/wptheme/customized.css', 
      array('wptheme')
    );

  }





  /**
   * Regenerate stylesheet when preview initialized
   * @param  [type] $wp_customize [description]
   * @return [type]               [description]
   */
  public function preview_init( $wp_customize )
  {
    $this->generate_stylesheet();

    $this->enqueue_customizer();

    // Enqueue customizations stylesheet
    wp_enqueue_style(
      'wptheme-customized', 
      $this->stylesheet_url(), 
      array('wptheme')
    );

  }

  /**
   * Regenerate stylesheet when mod option updated
   * @param  [type] $option [description]
   * @return [type]         [description]
   */
  public function update_option( $option )
  {
    if( $option !== 'theme_mods_wptheme' ) return;

    // $this->generate_stylesheet();
  }

  /**
   * Get the stylesheet path
   * @return [type] [description]
   */
  public function stylesheet()
  {
    $uploads = wp_get_upload_dir();

    $dir = $uploads['basedir'] . '/wptheme';

    if( ! is_dir($dir) ) wp_mkdir_p($dir);

    return $dir . '/customized.css';
  }

  /**
   * Get the stylesheet url
   * @return [type] [description]
   */
  public function stylesheet_url()
  {
    $stylesheet = $this->stylesheet();

    $modified = filemtime($stylesheet);

    $uploads = wp_get_upload_dir();

    return $uploads['baseurl'] . '/wptheme/customized.css?' . $modified;
  }

  /**
   * Generate the stylesheet
   * @return [type] [description]
   */
  public function generate_stylesheet()
  {
    $stylesheet = $this->stylesheet();

    file_put_contents($stylesheet, $this->generate_css() );

  }

  /**
   * Generate the css content
   * @return [type] [description]
   */
  public function generate_css()
  {
    $css = '';

    foreach($this->sections as $section)
    {
      $css .= $section->get_css();
    }

    return $css;


    // return 'body { background-color: #' . get_theme_mod('background_color') . '; }';
  }


  







}