<?php 

namespace WPTheme;

use WPTheme\Package;
use WPTheme\Font;


class Ajax
{
  public static function init()
  {

    // Ajax package search function
    add_action( 'wp_ajax_wpt_packagesearch', array( __CLASS__, 'packages'), 10);

    // Ajax package search function
    add_action( 'wp_ajax_wpt_snazzymaps', array( __CLASS__, 'snazzymaps'), 10);

    // Ajax package search function
    add_action( 'wp_ajax_wpt_googlefonts', array( __CLASS__, 'googlefonts'), 10);
  }

  public static function packages()
  { 
    // Check nonce
    if( ! wp_verify_nonce( element($_POST,'nonce'), 'wpt-settings' ) )
    {
      return Ajax::response(FALSE, array('error'=>'Nonce verification failed'));
    }

    $data = array(
      'post' => $_POST
    );

    if( $query = element($_POST, 'query') )
    {
      $data['packages'] = Package::search($query);
    }

    Ajax::response(TRUE, $data);
  }


  public static function snazzymaps()
  {
   
    // Check nonce
    if( ! wp_verify_nonce( element($_POST,'nonce'), 'wpt-settings' ) )
    {
      return Ajax::response(FALSE, array('error'=>'Nonce verification failed'));
    }

    $key = Settings::get('maps.snazzymaps.apikey');

    if( empty($key) )
    {
      return Ajax::response(FALSE, array('error'=>'Google Maps API key not set'));
    }

    $url = 'https://snazzymaps.com/explore.json?key='.$key;



    $filters = element($_POST, 'filters', array());

    $text  = element($filters, 'text', '');
    $sort  = element($filters, 'sort', 'popular');
    $tag   = element($filters, 'tag', '');
    $color = element($filters, 'color', '');
    $page  = element($filters, 'page', 1);

    foreach( array('text','sort','tag','color','page') as $param )
    {
      if( ! empty(${$param}) ) $url .= '&' . $param . '=' . urlencode(${$param}); 
    }

    $json = file_get_contents($url);

    if( empty($json) )
    {
      return Ajax::response(FALSE, array('error'=>'No results returned') );
    }


    return Ajax::response(TRUE, array('results'=>json_decode($json)));

  }

  public static function googlefonts()
  {
    // Check nonce
    if( ! wp_verify_nonce( element($_POST,'nonce'), 'wpt-settings' ) )
    {
      return Ajax::response(FALSE, array('error'=>'Nonce verification failed'));
    }

    $key = Settings::get('fonts.google.apikey');

    if( empty($key) )
    {
      return Ajax::response(FALSE, array('error'=>'API Key Missing'));
    }

    $filters = element($_POST, 'filters', array() );

    $limit = 25; 

    $sort = element($filters, 'sort', 'trending');
    
    $transient = 'wpt_google_fonts-' . $sort;

    $fonts = get_transient( $transient );

    if( empty($fonts) )
    {
      $url = 'https://www.googleapis.com/webfonts/v1/webfonts?sort='.$sort.'&key=' . $key;

      $json = file_get_contents($url);

      if( empty($json) )
      {
        return Ajax::response(FALSE, array('error'=>'No JSON data returned'));
      }
   
      $data = json_decode($json);

      $fonts = $data->items;

      set_transient( $transient, $fonts, DAY_IN_SECONDS );
    }


    $results = array();

    $keyword = element($filters, 'keyword', '');

    $rc = 0;

    foreach($fonts as $font)
    {
      if( $rc >= $limit ) break;

      $include = TRUE;

      if( ! empty($keyword)  )
      {
        $include = ( FALSE !== stripos($font->family, $keyword) );
      }

      if( $include )
      {
        $results[] = $font; 
        $rc++;
      }
     
    }
  
      
  
    Ajax::response(TRUE, array('results'=>$results,'categories'=>$categories,'filters'=>$filters));
   
  }


  public static function response( $success, $data = array() )
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