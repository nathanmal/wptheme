<?php 

namespace WPTheme\Customize;

use \WP_Customize_Control;

class Control extends WP_Customize_Control
{



  public function enqueue()
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



}