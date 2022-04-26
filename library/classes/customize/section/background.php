<?php

namespace WPTheme\Customize\Section;

use WPTheme\Customize\Section;

class Background extends Section
{
  
  public function add_settings()
  {



    




    $this->add_control( 'background', 'background', 'Background' );


    $this->add_setting('background[color]', array(
      'default' => '#FFFFFF',
      'transport' => 'refresh'
    ));

    $this->add_control( 'background[color]', 'color', 'Background Color' );


    $this->add_setting( 'background[image]', array(
      'default' => '',
      'sanitize_callback' => 'esc_url_raw',
      'transport' => 'refresh'
    ));


    $this->add_control( 'background[image]', 'image', 'Background Image' );


    $this->add_setting(
      'background[size]',
      array(
        'default' => 'auto',
        'transport' => 'refresh'
      )
    );

    $this->add_control(
      'background[size]',
      'select',
      __( 'Image Size' ),
      array(
        'choices' => array(
          'auto'    => _x( 'Original', 'Original Size' ),
          'contain' => __( 'Contain' ),
          'cover'   => __( 'Cover' ),
        ),
      )
    );


    $this->add_setting(
      'testing',
      array(
        'default' => 'auto',
        'transport' => 'refresh'
      )
    );

    $this->add_control(
      'testing',
      'slider',
      'Slider Control'
    );



    /*
    $this->add_setting( 'background_color', array(
      'default' => '#FFFFFF',
      'transport' => 'refresh'
    ));

    $this->add_control( 'background_color', 'color', 'Background Color' );


    $this->add_setting( 'background_image', array(
      'default' => '',
      'sanitize_callback' => 'esc_url_raw',
      'transport' => 'refresh'
    ));


    $this->add_control( 'background_image', 'image', 'Background Image' );


    
    $this->add_setting( 'background_position_x', array(
      'default' => '',
      'transport' => 'refresh'
    ));

    $this->add_setting( 'background_position_y', array(
      'default' => '',
      'transport' => 'refresh'
    ));

    $this->add_control( 
      'background_position', 
      'background_position', 
      'Background Position',
      array(
        'settings'=>array(
          'x' => 'background_image_position_x',
          'y' => 'background_image_position_y'
        )
    ));
    */



  }




  public function get_css()
  {
    $css = 'body { background-color: #' . get_theme_mod('background_color') . '; }' . "\n";

    $css .= '#background { background-image: url("'. get_theme_mod('background_image').'");';

    return $css;
  }

}