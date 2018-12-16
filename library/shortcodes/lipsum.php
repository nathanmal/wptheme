<?php


if ( ! function_exists('wptheme_lipsum') ) {

    function wptheme_lipsum()
    {
      return file_get_contents('http://loripsum.net/api');
    }

    add_shortcode( 'lipsum' , 'wptheme_lipsum' );

}