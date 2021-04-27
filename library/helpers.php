<?php 
/**
 * WP Theme Helper functions
 *
 * a collection of global functions made available to the theme
 * 
 */


/**
 * Get the theme class instance
 * @return [type] [description]
 */
function wpt()
{
  return \WPTheme\Theme::instance();
}


/**
 * Load a partial view file
 * @param  string  $path   [description]
 * @param  array   $data   [description]
 * @param  boolean $return [description]
 * @return [type]          [description]
 */
function wpt_partial( string $slug, array $args = [], $return = FALSE )
{
  ob_start();

  $path = 'views/partials/' . $slug;

  if( FALSE === get_template_part( $path, NULL, $args ) )
  {
    $content = '[Partial missing: ' . $path . ']';
  }
  else
  {
    $content = ob_get_contents();
  }
  
  ob_end_clean();

  if( $return ) return $content;

  echo $content;

  // return wpt()->partial($path, $data, $return);
}

/**
 * Render a navigation menu
 * @param  string $name [description]
 * @param  array  $args [description]
 * @return [type]       [description]
 */
function wpt_menu( string $name, array $args = [] )
{
  wpt()->menu($name, $args);
}


/**
 * Write the page title
 * @return [type] [description]
 */
function wpt_title()
{
  echo '<title>'.wp_title('|', FALSE).'</title>';
}

/**
 * Echo the page/post content
 * @return [type] [description]
 */
function wpt_content()
{
  the_content();
}



/**
 * Get an asset url
 * @param  string $path [description]
 * @return [type]       [description]
 */
function wpt_url( string $path )
{
  if( file_exists( STYLESHEETPATH . '/' . $path ) )
  {
    return get_stylesheet_directory_uri() . '/' . $path;
  }

  if( file_exists( TEMPLATEPATH . '/' . $path ) )
  {
    return get_template_directory_uri() . '/' . $path;
  }

  return '';
}


/**
 * Display the branding in the main navbar
 * @return [type] [description]
 */
function wpt_brand()
{
  echo bloginfo('title');
}



/**
 * Display site copyright
 * @return [type] [description]
 */
function wpt_copyright()
{
  echo '<p class="copyright">All content and media copyright &copy; '.bloginfo('name').' '.date('Y').'</p>';
}



/**
 * Get the shortname of a namespaced class
 * @param  [type] $object [description]
 * @return [type]         [description]
 */
function wpt_shortname( $object )
{
  return (new \ReflectionObject($object))->getShortName();
}




/**
 * Fetch an element from an array, allowing multidimentional search with . separators
 * @param  [type] &$array  [description]
 * @param  [type] $key     [description]
 * @param  [type] $default [description]
 * @return [type]          [description]
 */
function wpt_element( &$array, $key, $default=NULL )
{
  if( $p = strpos($key, '.') )
  {
    $c = substr($key, 0, $p); $n = substr($key, $p+1);

    return ( isset($array[$c]) && is_array($array[$c]) ) ? wpt_element( $array[$c], $n, $default ) : $default;
  }

  return ( is_array($array) && isset($array[$key]) ) ? $array[$key] : $default;
}


/**
* Print out an variable in a <pre></pre> block
* @param  [type] $obj [description]
* @return [type]      [description]
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



function wpt_post_container_class( $classes = array() )
{
  return 'container-fluid';
}


function wpt_navbar_class()
{
  return 'navbar-shy navbar-expand-md';
}

/**
 * Enforce prefix on string
 * @param  string $str    [description]
 * @param  string $prefix [description]
 * @return [type]         [description]
 */
function wpt_prefix( string $str, string $prefix )
{
  return str_starts_with( $str, $prefix ) ? $str : $prefix . $str;
}



/**
 * Enforce suffix on a string
 * @param  string $str    [description]
 * @param  string $suffix [description]
 * @return [type]         [description]
 */
function wpt_suffix( string $str, string $suffix )
{
  return str_ends_with($str,$suffix) ? $str : $str . $suffix;
}



if( ! function_exists('str_starts_with') )
{
  function str_starts_with($haystack, $needle) 
  {
    return substr($haystack, 0, strlen($needle)) === $needle;
  }
}

if( ! function_exists('str_ends_with') )
{
  function str_ends_with($haystack, $needle) 
  {
    return substr($haystack,-strlen($needle))===$needle;
  }
}





function wpt_log( $var )
{
  if( is_object($var) OR is_array($var) )
  {
    $var = print_r($var,TRUE);
  }

  if( defined('WP_DEBUG_LOG') && is_file(WP_DEBUG_LOG) )
  {
    error_log($var, 3, WP_DEBUG_LOG);
  }
  else
  {
    error_log($var);
  }
}







function wpt_labelize( $str )
{
  return ucwords(str_replace(['_','-'],' ',$str));
}



function wpt_slugify( $str )
{
  return strtolower(str_replace(' ','_',$str));
}



function wpt_section( $id, $content )
{
  echo '<section id="' . $id . '">';
  echo '<div class="container">';
  echo $content;
  echo '</div>';
  echo '</section>';
}


/**
 * Get slug of a post
 * @param  int $post_id ID of post
 * @return string|false FALSE if post is not a page
 */
function get_post_slug($post_id)
{
    $post = get_post($post_id);
    return $post ? $post->post_name : FALSE;
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



if( ! function_exists('prefix') )
{
  function prefix( $str, $prefix = '' )
  {
    return ( !! strlen($prefix) && 0 === strpos($str, $prefix) ) ? $str : $prefix . $str;
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

if( ! function_exists('backtrace_array') )
{
  function backtrace_array()
  {
    $trace = debug_backtrace();
    $out   = [];

    foreach($trace as $item)
    {
      $class = wpt_element($item,'class');
      $func  = wpt_element($item,'function');
      $file  = wpt_element($item,'file');
      $line  = wpt_element($item,'line');
      
      $str = ( $class ? $class .'::'.$func : $func ) . '() ' . "\t";
      $str .= $file . ' [line ' . $line;

      $out[] = $str;

    }

    return $out;
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


