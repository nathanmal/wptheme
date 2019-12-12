<?php
if ( ! function_exists('wpt_shortcode_lipsum') ) 
{
    function wpt_shortcode_lipsum()
    {
      return file_get_contents('http://loripsum.net/api');
    }

    add_shortcode( 'wpt:lipsum' , 'wpt_shortcode_lipsum' );
}