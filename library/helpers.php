<?php 
/**
 * WP Theme Helper functions
 *
 * a collection of global functions made available to the theme
 * 
 */

/**
 * Echo empty template header
 */
if ( ! function_exists('template_placeholder') ){

    function template_placeholder( $name = '' ){

        $template = Theme::getTemplate();
        echo '<style>body { margin:0 }</style>';
        echo '<div style="margin:0;text-align:center;display:flex;flex-direction:column;justify-content:center;align-items:center;height:100vh;width:100%;background:#eee;margin-bottom:">';
        echo '<h1>[' . strtoupper($name) . ' Template]<h1/>';
        echo '<h2>Edit at /library/views/'.$template.'.php</h2>';
        echo '</div>';
    }
}

/**
 * Print out an object or array in a pre element for debugging
 */
if( ! function_exists('pre') ) 
{
    function pre($obj)
    {
        echo '<div class="pre-debug"><pre>';
        if( is_array($obj) ) {
            print_r($obj);
        } else {
            var_dump($obj);
        }
        echo '</pre></div>';
    }
}

/**
 * Access array elements easily, with default
 */
if( ! function_exists('element') )
{
    function element(&$array, $key, $default=NULL)
    {
        return ( is_array($array) && isset($array[$key]) ) ? $array[$key] : $default;
    }
}


/**
 * Get slug of a post
 * @param  int $post_id ID of post
 * @return string|false FALSE if post is not a page
 */
if( ! function_exists('get_post_slug') )
{
    function get_post_slug($post_id)
    {
        $post = get_post($post_id);
        return $post ? $post->post_name : FALSE;
    }
}
