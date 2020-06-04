<?php 
/**
 * WP Theme Helper functions
 *
 * a collection of global functions made available to the theme
 * 
 */


/**
 * Access array elements easily, with default
 */
if( ! function_exists('element') )
{
    function element( &$array, $key, $default=NULL )
    {
      if( $p = strpos($key, '.') )
      {
        $c = substr($key, 0, $p); $n = substr($key, $p+1);

        return ( isset($array[$c]) && is_array($array[$c]) ) ? element( $array[$c], $n, $default ) : $default;
      }

      return ( is_array($array) && isset($array[$key]) ) ? $array[$key] : $default;
    }
}


if( ! function_exists('wpt_labelize') )
{
  function wpt_labelize( $str )
  {
    return ucwords(str_replace(['_','-'],' ',$str));
  }
}

if( ! function_exists('wpt_slugify') )
{
  function wpt_slugify( $str )
  {
    return strtolower(str_replace(' ','_',$str));
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
 * Get the current page URL
 */
if( ! function_exists('current_url') )
{
  function current_url()
  {
    global $wp;
    return home_url($wp->request);
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


if( ! function_exists('prefix') )
{
  function prefix( $str, $prefix = '' )
  {
    return ( !! strlen($prefix) && 0 === strpos($str, $prefix) ) ? $str : $prefix . $str;
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



if( ! function_exists('wpt_filed_under') )
{
  function wpt_filed_under( $post, $taxonomy = 'category', $limit = 1, $link = TRUE, $target = '_blank' )
  {
    $terms = get_the_terms( $post, $taxonomy );

    echo '<div class="filed-under">Filed under';
    wpt_category_list($post,$taxonomy,$limit,$link,$target);
    echo '</div>';

  }
}

if( ! function_exists('wpt_category_list') )
{
  function wpt_category_list( $post, $taxonomy = 'category', $limit = 1, $link = TRUE, $target = '_blank', $return = FALSE )
  {
    $terms = get_the_terms( $post, $taxonomy );
    $c = 0;
    $out = '';

    if( ! empty($terms) )
    {
      $out = '<ul class="terms terms-'.$taxonomy.'">';
      foreach($terms as $term)
      {
        if( $c >= $limit ) break;
        $out .= '<li class="term">';
        if( $link ) $out .= '<a href="' . get_term_link($term->term_id) .'" target="' . $target .'">';
        $out .= '<span class="term-name">' . $term->name . '</span>';
        if( $link ) $out .= '</a>';
        $out .= '</li>';
        $c++; 
      }
      $out .= '</ul>';
    }
    

    if( $return ) return $out;

    echo $out;
  }
}


/**
 * Return category list as string
 */
if( ! function_exists('wpt_get_category_list') )
{
  function wpt_get_category_list( $post, $taxonomy = 'category', $limit = 1, $link = TRUE, $target = '_blank' )
  {
    return wpt_category_list( $post, $taxonomy, $limit, $link, $target, TRUE );
  }
}

/**
 * Get 
 */
if( ! function_exists('wpt_get_excerpt') )
{
  function wpt_get_excerpt( $post = NULL, $length = NULL)
  {
    $post = get_post($post);
    // Use excerpt if it exists
    if( ! empty($post->post_excerpt) ) return $post->post_excerpt;

    // Otherwise generate it from content
    $text = strip_shortcodes( $post->post_content );
    $text = apply_filters( 'the_content', $text );
    $text = str_replace(']]>', ']]&gt;', $text);
    $excerpt_length = intval($length) ?: apply_filters( 'excerpt_length', 55 );
    $excerpt_more = apply_filters( 'excerpt_more', '&nbsp;[&hellip;]' );
    $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
    return $text;
  }
}



/**
 * Get enqueued assets
 */
if( ! function_exists('wpt_enqueued') )
{
    function wpt_enqueued( $type = NULL )
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
        return WPTheme\Setting::get($key, $default);
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