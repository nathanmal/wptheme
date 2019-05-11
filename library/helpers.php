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

        $template = Theme::template();
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
    function element( &$array, $key, $default=NULL )
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



if( ! function_exists('classes') )
{
    function classes( $classes )
    {
        return is_array($classes) ? implode(' ', $classes) : $classes;
    }
}


if( ! function_exists('html_video') )
{
    function html_video( $src, $config = array() )
    {
        $video = '<video src="' . $src .'" ';

        if( isset($config['class']) ) $video .= 'class="'  . classes($config['class']) . '" ';

        foreach( array('width','height','poster') as $attr )
        {
            if( isset($config[$attr]) ) $video .= $attr.='="'.$config[$attr].'" ';
        }

        foreach( array('autoplay','muted','loop','preload','controls') as $attr )
        {
            if( isset($config[$attr]) OR in_array($attr, $config) ) $video .= $attr .' ';
        }   

        $video .= '>';

        if( isset($config['src']) && is_array($config['src']) )
        {
            foreach($config['src'] as $src)
            {
                $video .= '<source src="' . $src['src'].'" type="' . $src['type'] .'">';
            }
        }

        // Show message in case of lack of html5 support
        $video .= element($config, 'support', 'Your browser does not support the video tag');

        $video .= '</video>';

        return $video;

    }
}

/**
 * array_contains
 * Checks if $str is either a value or a key
 */
if( ! function_exists('array_contains') )
{
    function array_contains( &$array, $str )
    {
        return is_string($str) && ( isset($array[$str]) OR in_array($str, $array) ); 
    }
}


if( ! function_exists('enqueued') )
{
    function enqueued( $type = NULL )
    {
        global $wp_scripts, $wp_styles;

        $list = array('scripts'=>[],'styles'=>[]);

        foreach( $wp_scripts->queue as $script )
            $list['scripts'][] = $wp_scripts->registered[$script];

        foreach( $wp_styles->queue as $style)
            $list['styles'][] = $wp_styles->registered[$style];

        return $list;

    }
}