<?php
if ( ! function_exists('wpt_shortcode_map') ) 
{
    function wpt_shortcode_map( $args = array(), $content, $tag )
    {
      if( ! defined('THEME_GOOGLE_MAPS_KEY') OR empty(THEME_GOOGLE_MAPS_KEY) )
      {
        echo '[wpt:map missing google maps API key]';
        return;
      }

      $center = element($args, 'center');
      $style  = element($args, 'style');
      $marker = element($args, 'marker');
      $zoom   = element($args, 'zoom', 11);


      if( empty($center) OR FALSE === strpos($center,',') )
      {
        echo '[wpt:map Invalid center]';
        return;
      }

      // Print element
      echo '<div class="wpt-map" ';
      echo 'data-center="'.$center.'" ';
      echo 'data-zoom="'.$zoom.'" ';
      echo 'data-style="'.json_decode(stripslashes($style)).'" ';
      echo 'data-marker="'.$marker.'" ';
      echo 'data-marker-title="'.element($args, 'marker-title','').'" ';
      echo 'data-marker-content="'.element($args, 'marker-content','').'" ';
      echo '></div>';

      // enqueue google maps API
      $src = 'https://maps.googleapis.com/maps/api/js?callback=theme.googlemap.init&key='.THEME_GOOGLE_MAPS_KEY;
      wp_enqueue_script( 'google-maps', $src, array('wptheme'), NULL, TRUE );
      
    }

    add_shortcode( 'wpt:map' , 'wpt_shortcode_map' );
}