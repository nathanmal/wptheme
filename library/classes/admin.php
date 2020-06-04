<?php 

namespace WPTheme;

use WPTheme\Theme;
use WPTheme\Enqueue;
use WPTheme\Ajax;
use WPTheme\Admin\Page;

class Admin
{
  /**
   * Initialize theme admin
   * @return [type] [description]
   */
  public static function init()
  {
    // Add menu
    add_action( 'admin_menu', array( '\WPTheme\Admin\Page', 'init'), 10 );

    // Enqueue plugin admin scripts
    add_action( 'admin_enqueue_scripts', array( __CLASS__ , 'enqueue'), 10 );

    // Initialize ajax
    Ajax::init();

    // Include admin functions
    require_once( THEME_DIR . '/config/admin.php' );
  }

  /**
   * Enqueue admin assets
   * @return [type] [description]
   */
  public static function enqueue()
  {
    // core scripts
    Enqueue::script('jquery-ui-core');
    Enqueue::script('jquery-ui-sortable');

    // admin scripts
    Enqueue::script('wptheme.admin', Theme::asset('dist/admin.js'), array('jquery-core'));

    // admin styles
    Enqueue::style('wptheme.admin', Theme::asset('dist/admin.css') );
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