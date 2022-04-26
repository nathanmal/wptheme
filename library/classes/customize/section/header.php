<?php

namespace WPTheme\Customize\Section;

use WPTheme\Customize\Section;

class Header extends Section
{



  public function add_settings()
  {
    $this->add_setting( 'header[height]', array(
      'default'           => '100',
      'transport'         => 'postMessage',
      'sanitize_callback' => 'absint'
    ));

    $this->add_control(
      'header[height]', 
      'slider', 
      'Header Height',
      array(
        'input_attrs' => array(
          'min' => 32,
          'max' => 120,
          'unit' => 'px'
        )
      )
    );


    $this->add_setting( 'header[bgcolor]', array(
      'default' => '#FFFFFF',
      'transport' => 'postMessage'
    ));

    $this->add_control( 'header[bgcolor]', 'color', 'Background Color' );

    $this->add_setting( 'header[bgalpha]', array(
      'default' => 1,
      'transport' => 'postMessage'
    ));

    $this->add_control(
      'header[bgalpha]', 
      'slider', 
      'Header Transparency',
      array(
        'input_attrs' => array(
          'min' => 0,
          'max' => 1,
          'step' => '0.01'
        )
      )
    );


  }




  public function get_css()
  {
    
  }

}