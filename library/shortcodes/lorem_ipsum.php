<?php 

if ( ! function_exists('wptheme_lorem_ipsum') ) {

    function wptheme_lorem_ipsum(){

        return file_get_contents('http://loripsum.net/api');

    }

    add_shortcode( 'lorem_ipsum' , 'wptheme_lorem_ipsum' );

}