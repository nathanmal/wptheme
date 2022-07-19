<?php 

namespace WPTheme;

use WPTheme\Admin\Page;
use WPTheme\Package;
use WPTheme\Font;


class Ajax
{ 
  /**
   * Initialize ajax functions
   * @return [type] [description]
   */
  public static function init()
  {

    // Ajax package search function
    //add_action( 'wp_ajax_wpt_packagesearch', array( __CLASS__, 'packages'), 10);

    // Ajax package search function
    //add_action( 'wp_ajax_wpt_snazzymaps', array( __CLASS__, 'snazzymaps'), 10);

    // Ajax package search function
    //add_action( 'wp_ajax_wpt_googlefonts', array( __CLASS__, 'googlefonts'), 10);
  }

  /**
   * Send ajax response
   * @param  [type] $success [description]
   * @param  array  $data    [description]
   * @return [type]          [description]
   */
  public static function response( $success, $data = array() )
  {
    $data['success'] = !! $success;

    if( ! headers_sent() ) 
    {
      header("Content-Type: application/json");
    }

    echo json_encode($data);

    die();
  }
}