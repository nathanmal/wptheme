<?php 

namespace WPTheme;

use WPTheme\Settings;
use WPTheme\Theme;
use WPTheme\Package;

class Admin
{
  public static function init()
  {

    // Add menu
    add_action( 'admin_menu', array( '\WPTheme\Settings', 'init'), 10 );

    // Enqueue plugin admin scripts
    add_action( 'admin_enqueue_scripts', array( __CLASS__ , 'enqueue'), 10 );

    // Ajax package search function
    add_action( 'wp_ajax_wpt_packagesearch', array( __CLASS__, 'package_search'), 10);

    // Ajax package search function
    add_action( 'wp_ajax_wpt_snazzymaps', array( __CLASS__, 'snazzymap_search'), 10);

    // Ajax package search function
    add_action( 'wp_ajax_wpt_googlefonts', array( __CLASS__, 'googlefonts'), 10);
    
  }

  public static function enqueue()
  {
    // Add these for UI
    wp_enqueue_script( 'jquery-ui-core' );
    // Sortable for sorting files etc
    wp_enqueue_script( 'jquery-ui-sortable' );
    
    wp_enqueue_script('wptheme.admin', Theme::asset('dist/admin.js'), array('jquery-core'), NULL, TRUE);

    wp_enqueue_style('wptheme.admin', Theme::asset('dist/admin.css') );

  }

  

  



  public static function json( $success = TRUE, $data = array() )
  {

    $data['success'] = $success;

    if( ! headers_sent() ) 
    {
      header("Content-Type: application/json");
    }

    echo json_encode($data);

    die();
  }

}