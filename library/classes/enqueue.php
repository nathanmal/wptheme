<?php 

namespace WPTheme;

use WPTheme\Package;
use WPTheme\Settings;
use WPTheme\Component;

class Enqueue
{



  private static $libraries = array(

    // jQuery 3
    'jquery' => array(
      'js' => array( 
        'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'
      )
    ),

    // Bootstrap 4
    'bootstrap' => array(
      'js' => array(
        'src' => 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js',
        'dependencies' => ['jquery'],
        'version' => '4.4.1'
      ),
      'css' => array(
        'src' => 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css',
      )
    ),

    // Font Awesome 5
    'fontawesome' => array(
      'css' => array(
        'src' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css'
      )
    ),

    // Font Awesome 5 solid icons
    'fontawesome-solid' => array(
      'css' => array(
        'src' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/solid.min.css',
        'dependencies' => 'fontawesome'
      )
    ),

    // Font Awesome 5 brands
    'fontawesome-brands' => array(
      'css' => array(
        'src' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/brands.min.css',
        'dependencies' => 'fontawesome'
      )
    ),

    // Theme files
    'wptheme' => array(
      'js' => array(
        'src' => 'assets/dist/theme.js',
        'dependencies' => 'bootstrap',
        'version' => THEME_VERSION
      ),
      'css' => array(
        'src' => 'assets/dist/theme.css',
        'dependencies' => 'bootstrap',
        'version' => THEME_VERSION
      )
    )
  );


  /**
   * Script tag attributes
   * @var array
   */
  private static $script_attributes = array();


  /**
   * Register libraries
   * @return [type] [description]
   */
  public static function register_libraries()
  {
    foreach( Enqueue::$libraries as $handle => $lib )
    {
      $js  = element($lib, 'js', array());
      $css = element($lib, 'css',array());

      Enqueue::register($handle, $js, $css);
    }
  }

  /**
   * Register a library
   * @param  [type] $handle [description]
   * @param  [type] $js     [description]
   * @param  [type] $css    [description]
   * @return [type]         [description]
   */
  public static function register( $handle, $js = array(), $css = array() )
  {
    if( ! empty($js) ) {
      $src = element($js,'src','');
      $dep = element($js,'dependencies',array());
      $ver = element($js,'version',FALSE);
      $ftr = element($js,'footer',TRUE);

      if( 0 !== strpos($src,'http') ) $src = THEME_URI .'/' . ltrim($src,'/');

      wp_register_script( $handle, $src, $dep, $ver, $ftr );
    }

    if( ! empty($css) ) {
      $src = element($css,'src','');
      $dep = element($css,'dependencies',array());
      $ver = element($css,'version','');
      $med = element($css,'media','all'); 

      if( 0 !== strpos($src,'http') ) $src = THEME_URI .'/' . ltrim($src,'/');

      wp_register_style( $handle, $src, $dep, $ver, $med );
    }
  }

  /**
   * Enqueue a registered library
   * @param  [type] $handle [description]
   * @return [type]         [description]
   */
  public static function library( $handle )
  {
    $library = element(Enqueue::$libraries,$handle,array());

    if( ! empty($library) && isset($library['js']) && wp_script_is($handle,'registered') ) 
    {
      wp_enqueue_script($handle);
    }

    if( ! empty($library) && isset($library['css']) && wp_style_is($handle,'registered') ) 
    {
      wp_enqueue_style($handle);
    }
  }


  /**
   * Enqueue a script
   * @param  [type]  $handle  [description]
   * @param  [type]  $src     [description]
   * @param  string  $version [description]
   * @param  array   $dep     [description]
   * @param  boolean $footer  [description]
   * @return [type]           [description]
   */
  public static function script( $handle, $src = '', $dependencies = array(), $version = NULL, $footer = TRUE, $attr = array() )
  {
    if( wp_script_is($handle, 'registered') ) return wp_enqueue_script($handle);

    // if not absolute URL then assume local path
    if( strpos($src, 'http') !== 0 ) $src = THEME_URI . '/' . $src;

    // store attributes to print out later, if supplied
    if( ! empty($attr) && is_array($attr) ) Enqueue::$script_attributes[$handle] = $attr;

    // enqueue the script
    wp_enqueue_script( $handle, $src, $dependencies, $version, $footer );
  }


  /**
   * Enqueue a style
   * @param  [type] $handle    [description]
   * @param  [type] $src     [description]
   * @param  string $version [description]
   * @param  array  $dep     [description]
   * @param  string $media   [description]
   * @return [type]          [description]
   */
  public static function style( $handle, $src = '', $dependencies = array(), $version = '', $media = 'all' )
  {
    // Check if already registered
    if( wp_style_is($handle, 'registered') ) return wp_enqueue_style($handle);

    // if not absolute URL then assume local path
    if( strpos($src, 'http') !== 0 ) $src = THEME_URI . '/' . $src;

    // enqueue the style
    wp_enqueue_style($handle, $src, $dependencies, $version, $media);
  }




  /**
   * Adds ability to include custom attributes on enqueued script tags
   * @param [type] $tag    [description]
   * @param [type] $handle [description]
   * @param [type] $src    [description]
   */
  public static function script_attributes( $tag, $handle, $src )
  {
    $attr = element( Enqueue::$script_attributes, $handle );

    if( ! empty($attr) && is_array($attr) )
    {
      $tag = '<script type="text/javascript" src="' . $src . '" ';

      foreach( $attr as $key => $value )
      {
        $tag .= is_int($key) ? $value . ' ' : $key .'="'.$value.'" ';
      }

      $tag .= '></script>' . "\n";

    }

    return $tag;
  }


  /**
   * Strips version attribute from asset URLs
   * @category optimization
   * @param  string $src URL to check
   * @return [type]      [description]
   */
  public static function remove_asset_version( $src )
  {
    return strpos( $src, 'ver=' ) ? remove_query_arg( 'ver', $src ) : $src;
  }



  
  /**
   * Enqueue Google Font
   * @param  [type] $family   [description]
   * @param  array  $variants [description]
   * @return [type]           [description]
   */
  public static function googlefont( $family, $variants = array() )
  { 
    // google fonts API
    $src  = 'https://fonts.googleapis.com/css?family=' . $family;

    // add variants
    if( ! empty($variants) && is_array($variants) ) $src .= ':' . implode(',', $variants);
    
    // enqueue the font
    Enqueue::font( $family, $src );
  }



  /**
   * Enqueue Local Font
   * @param  [type] $family   [description]
   * @param  string $src      path to font stylesheet
   * @return [type]           [description]
   */
  public static function font( $family, $src )
  {
    // validate src
    if( empty($src) OR ! is_string($src) ) return;

    // if not absolute URL then assume local path
    if( strpos($src, 'http') !== 0 ) $src = THEME_URI . '/assets/fonts/' . $src;

    // enqueue font
    Enqueue::style( 'font-' . strtolower($family), $src );
  }



  
}