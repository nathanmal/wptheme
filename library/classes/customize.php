<?php

namespace WPTheme;


class Customize
{

  public static function init( $wp_customize )
  {
    new Customize($wp_customize);


  }


  public function __construct( $wp_customize )
  {
    $this->wp = $wp_customize;

    $this->add_sections();

    add_action( 'updated_option', array( $this, 'update' ), 10, 1 );

    add_action( 'customize_preview_init', array( $this, 'preview'), 10, 1);
  }

  public function preview( $wp_customize )
  {
    $this->generate_stylesheet();

    wp_enqueue_style('wptheme-customized', $this->stylesheet_url(), array('wptheme') );

  }

  public function update( $option )
  {
    if( $option !== 'theme_mods_wptheme' ) return;

    // $this->generate_stylesheet();
  }


  public function stylesheet()
  {
    $uploads = wp_get_upload_dir();

    $dir = $uploads['basedir'] . '/wptheme';

    if( ! is_dir($dir) ) wp_mkdir_p($dir);

    return $dir . '/customized.css';
  }

  public function stylesheet_url()
  {
    $stylesheet = $this->stylesheet();

    $modified = filemtime($stylesheet);

    $uploads = wp_get_upload_dir();

    return $uploads['baseurl'] . '/wptheme/customized.css?' . $modified;
  }


  public function generate_stylesheet()
  {
    $stylesheet = $this->stylesheet();

    file_put_contents($stylesheet, $this->generate_css() );

  }


  public function generate_css()
  {
    return 'body { background-color: #' . get_theme_mod('background_color') . '; }';
  }


  public function add_sections()
  {
    $this->wp->add_section( 'page', array(
      'title' => 'Page',
      'priority' => 30
    ));

    $this->wp->add_setting( 'background_color', array(
      'default' => '#FFFFFF',
      'transport' => 'refresh'
    ));


    $config = array(
      'label' => 'Background Color',
      'section' => 'page',
      'settings' => 'background_color'
    );

    $this->wp->add_control( new \WP_Customize_Color_Control( $this->wp, 'background_color', $config) );

  }







}