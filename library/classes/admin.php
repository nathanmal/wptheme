<?php 

namespace WPTheme;

use WPTheme\Settings;
use WPTheme\Theme;

class Admin
{
  public static function init()
  {
    
    // Add menu
    add_action( 'admin_menu', array( __CLASS__ , 'admin_menu'), 10 );

    // Enqueue plugin admin scripts
    add_action( 'admin_enqueue_scripts', array( __CLASS__ , 'enqueue'), 10 );


    
  }

  public static function enqueue()
  {
    wp_enqueue_script('wptheme.admin', Theme::asset('dist/admin.js'), array('jquery-core'), NULL, TRUE);

    wp_enqueue_style('wptheme.admin', Theme::asset('dist/admin.css') );

  }

  public static function admin_menu()
  {
    // Main plugin menu
    add_menu_page(
      'WPTheme',
      'WPTheme',
      'manage_options',
      'wptheme',
      array( 'WPTheme\Settings', '_render' ), 
      NULL, // Icon
      '79'
    );


  }

}