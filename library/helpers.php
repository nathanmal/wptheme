<?php 
/**
 * WP Theme Helper functions
 *
 * a collection of global functions made available to the theme
 * 
 */


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
 * Get the short class name of an object without namespace
 */
if( ! function_exists('get_class_shortname') )
{
  function get_class_shortname( $object )
  {
    return (new \ReflectionObject($object))->getShortName();
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

/**
 * Combine array of classnames
 */
if( ! function_exists('classes') )
{
    function classes( $classes )
    {
        return is_array($classes) ? implode(' ', $classes) : $classes;
    }
}

/**
 * Generate an html list based on categories for post
 */
if( ! function_exists('category_list') )
{
  function category_list( $post_id, $taxonomy = 'category', $permalink = TRUE, $class = '' )
  {
    $terms = get_the_terms( $post_id, $taxonomy );

    if( ! empty($terms) )
    {
      echo '<ul class="category-list ' . $class . '">';

      foreach($terms as $term)
      {

         if( is_string($permalink) )
         {
            $link = sprintf($permalink, $term->ID);    
         } 
         else if( TRUE === $permalink )
         {
            $link = get_term_link( $term, $taxonomy );
         }
         else
         {
            $link = FALSE;
         }

        echo '<li>';

        echo !! $link ? '<a href="'.$link.'">' . $term->name . '</a>' : $term->name;

        echo '</li>';

        
      }

      echo '</ul>';
    }
  }
}


/**
 * Get enqueued assets
 */
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

/**
 * Output video background for WPTheme banner
 */
if( ! function_exists('wpt_banner_video') )
{
    function wpt_banner_video( $video, $poster = '' )
    {
       wpt_background_video($video, $poster);
    }
}

/**
 * Output video tag for background video, using poster image as fallback
 */
if( ! function_exists('wpt_background_video') )
{
    function wpt_background_video($video, $poster = '')
    {
        echo '<video class="video-background" playsinline loop muted autoplay ';

        if( ! empty($poster) ) 
        {
            echo 'poster="' . $poster .'"';
        }

        echo '>';

        if( is_string($video) )
        {
            $video = array( $video => mime_content_type($video) );
        }

        foreach($video as $src => $type)
        {
            echo '<source src="' . $src . '" type="' . $type .'" />';
        }

        if( ! empty($poster) )
        {
            echo '<img class="video-background-poster" src="' . $poster . '"/>';
        }

        echo '</video>';
    }
}


/**
 * Get a theme setting
 */
if( ! function_exists('wpt_setting') )
{
    function wpt_setting($key, $default = FALSE)
    {
        return WPTheme\Settings::get($key, $default);
    }
}


/**
 * Load a theme partial view
 */
if( ! function_exists('wpt_partial') )
{
  function wpt_partial( $path, $data = array(), $repeat = 1 )
  {
    WPTheme\Theme::partial( $path, $data, $repeat );
  }
}