<?php 

namespace WPTheme;

class Package 
{ 

  /**
   * Loaded packages
   * @var array
   */
  private static $packages = array();


  /**
   * Enqueued script attributes
   * @var array
   */
  private static $scripts = array();

  /**
   * Enqueued style attributes
   * @var array
   */
  private static $styles  = array();

  /**
   * Load package array
   * @param  [type] $name [description]
   * @return [type]       [description]
   */
  public static function load( $name )
  {
    if( ! isset(Package::$packages[$name]) )
    {
      $file = THEME_LIB . '/packages/' . $name . '.php';

      if( is_file($file) )
      {
        Package::$packages[$name] = include $file;
      }
      else
      {
        wp_die('Could not load package: ' . $name);
      }

    }

    return Package::$packages[$name];
  }



  public static function all()
  {
    $files = list_files( THEME_LIB . '/packages' );

    $packages = array();

    foreach($files as $file)
    {
      $name = pathinfo($file, PATHINFO_FILENAME);

      $packages[$name] = Package::load($name);
    }

    return $packages;
  }

  /**
   * Filter script tag attributes
   * @param  [type] $tag    [description]
   * @param  [type] $handle [description]
   * @param  [type] $src    [description]
   * @return [type]         [description]
   */
  public static function script_attributes( $tag, $handle, $src )
  {
    $package = element(Package::$scripts, $handle, FALSE);

    if( $package )
    {
      $extra = '';

      if( isset($package['integrity']) )
      {
        $extra .= ' integrity="' . $package['integrity'] . '"';
      }

      if( isset($package['crossorigin']) )
      {
        $extra .= ' crossorigin="' . $package['crossorigin'] . '"';
      }

      if( isset($package['async']) OR in_array('async', $package) ) 
      {
        $extra .= ' async';
      }

      if( isset($package['defer']) OR in_array('defer', $package) )
      {
        $extra .= ' defer';
      }

      if( ! empty($extra) )
      {
        $tag = preg_replace('/><\/script>$/', $extra . '></script>', $tag);
      }
    }

    return $tag;
  }

  /**
   * Filter style tag attributes
   * @param  [type] $tag    [description]
   * @param  [type] $handle [description]
   * @param  [type] $src    [description]
   * @return [type]         [description]
   */
  public static function style_attributes( $tag, $handle, $src )
  {
    $package = element(Package::$styles, $handle, FALSE);

    if( $package )
    {
      $extra = '';

      if( isset($package['integrity']) )
      {
        $extra .= ' integrity="' . $package['integrity'] . '"';
      }

      if( isset($package['crossorigin']) )
      {
        $extra .= ' crossorigin="' . $package['crossorigin'] . '"';
      }

      if( ! empty($extra) )
      {
        $tag = preg_replace('/\/>$/', $extra . '/>', $tag);
      }
    }

    return $tag;
  }

  /**
   * Enqueue Google Font
   * @param  [type] $family [description]
   * @param  array  $sizes  [description]
   * @return [type]         [description]
   */
  public static function google_font( $family, $sizes = array(400) )
  {
    $src = 'https://fonts.googleapis.com/css?family=' . $family;

    if( ! empty($sizes) )
    {
      $src .= ':' . implode(',', $sizes);
    }

    $src .= '&display=swap';

    wp_enqueue_style( 'font-' . strtolower($family), $src );

  }

  /**
   * Enqueue package assets
   * @param  string  $name    name of the package
   * @param  boolean $use_cdn use CDN (if configured, falls back to local if not)
   * @return [type]           [description]
   */
  public static function enqueue( $name, $use_cdn = FALSE, $localdata = array() )
  {
    $package = Package::load($name);

    if( $package )
    {
      // Remove scripts/styles from core if these are replacements
      if( wp_script_is($name, 'registered') ) wp_deregister_script( $name );
      if( wp_script_is($name, 'enqueued') ) wp_dequeue_script( $name );
      if( wp_style_is($name, 'registered') )  wp_deregister_style( $name );
      if( wp_style_is($name, 'enqueued') ) wp_dequeue_style($name);


      $slug    = element( $package, 'name', $name );
      $version = element( $package, 'version' );
      $js      = element( $package, 'js', array() );
      $css     = element( $package, 'css', array() );

      $dep_js  = element( $js, 'dependencies', array() );
      $dep_css = element( $css, 'dependencies', array() );
 
      // Get CDN assets if specified
      $styles  = $use_cdn && isset($css['cdn']) ? $css['cdn'] : element($css, 'local', array());
      $scripts = $use_cdn && isset($js['cdn'])  ? $js['cdn']  : element($js, 'local', array());

      // Enqueue package stylesheets
      foreach( $styles as $style )
      {
        $handle = isset($style['name']) ? $slug .'-'.$style['name'] : $slug;

        // Get source URL
        $src    = element( $style, 'src' );

         // Localize src URL
        if( 0 !== strpos($src, 'http') ) $src = THEME_URI . '/assets'  . $src;

        // Must be there
        if( empty($src) ) continue;

        // Get enqueue params
        $dependencies = element( $style, 'dependencies', $dep_css );
        $media        = element( $style, 'media', 'screen' );


        Package::$styles[$handle] = $style;

        wp_enqueue_style( $handle, $src, $dependencies, $version, $media );
      }

      // Enqueue package scripts
      foreach( $scripts as $script )
      {
        $handle = isset($script['name']) ? $slug .'-'.$script['name'] : $slug;

        // Get source URL
        $src = element( $script, 'src' );

        // Must be there
        if( empty($src) ) continue;

        // Localize src URL
        if( 0 !== strpos($src, 'http') ) $src = THEME_URI . '/assets'  . $src;
     
        // Get enqueue params
        $dependencies = element( $script, 'dependencies', $dep_js );

        // Allow script placement selection
        $footer = !! element($script, 'footer', TRUE);

        // Add to enqueued scripts
        Package::$scripts[$handle] = $script;

        // Enqueue the script
        wp_enqueue_script($handle, $src, $dependencies, $version, $footer);
      }
    }
  }

}