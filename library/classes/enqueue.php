<?php 

namespace WPTheme;

use WPTheme\Package;
use WPTheme\Settings;
use WPTheme\Component;

class Enqueue
{


  /**
   * Global theme dependencies
   * @var array
   */
  private static $dependencies = array('jquery','bootstrap');


  /**
   * Script tag attributes
   * @var array
   */
  private static $script_attributes = array();


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