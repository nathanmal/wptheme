<?php 

namespace WPTheme;

use WPTheme\Package;
use WPTheme\Settings;
use WPTheme\Component;

class Enqueue
{

  private static $script_attributes = array();

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
   * Enqueue jQuery
   * @return [type] [description]
   */
  public static function jquery()
  {
    $jquery = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js';
    $attr   = array('SameSite'=>'None','Secure');
    Enqueue::script( 'jquery', $jquery, array(), '3.4.1', TRUE );
  }

  /**
   * Enqueue Bootstrap
   * @return [type] [description]
   */
  public static function bootstrap()
  {
    $bsjs = 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js';
    $attr   = array('SameSite'=>'None','Secure');
    Enqueue::script( 'bootstrap', $bsjs, array('jquery'), '4.4.1', TRUE );
    $bscss = 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css';
    Enqueue::style( 'bootstrap', $bscss );
  }

  
  /**
   * Enqueue Google Font
   * @param  [type] $family   [description]
   * @param  array  $variants [description]
   * @return [type]           [description]
   */
  public static function googlefont( $family, $variants = array() )
  {
    $handle = 'font-' . strtolower($family);

    $src  = 'https://fonts.googleapis.com/css?family=' . $family;

    if( ! empty($variants) )
    {
      $src .= ':' . implode(',', $variants);
    }

    Enqueue::style( $handle, $src );
  }

  /**
   * Enqueue Local Font
   * @param  [type] $family   [description]
   * @param  string $src      path to font stylesheet
   * @return [type]           [description]
   */
  public static function font( $family, $src = '' )
  {
    if( empty($src) ) return;

    if( strpos($src, 'http') !== 0 )
    {
      $src = THEME_URL . '/assets/fonts/' . $src;
    }

    $handle = 'font-' . strtolower($family);

    Enqueue::style( $name, $src );
  }

  /**
   * Enqueue a script
   * @param  [type]  $name    [description]
   * @param  [type]  $src     [description]
   * @param  string  $version [description]
   * @param  array   $dep     [description]
   * @param  boolean $footer  [description]
   * @return [type]           [description]
   */
  public static function script( $handle, $src, $dependencies = array(), $version = '', $footer = TRUE, $attr = array() )
  {
    if( strpos($src, 'http') !== 0 )
    {
      $src = THEME_URL . '/' . $src;
    }

    if( ! empty($attr) && is_array($attr) )
    {
      Enqueue::$script_attributes[$handle] = $attr;
    }

    wp_deregister_script($handle);

    wp_enqueue_script($handle, $src, $dependencies, $version, $footer);
  }


  /**
   * Enqueue a style
   * @param  [type] $name    [description]
   * @param  [type] $src     [description]
   * @param  string $version [description]
   * @param  array  $dep     [description]
   * @param  string $media   [description]
   * @return [type]          [description]
   */
  public static function style( $name, $src, $dependencies = array(), $version = '', $media = 'all' )
  {
    if( strpos($src, 'http') !== 0 )
    {
      $src = THEME_URL . '/' . $src;
    }

    wp_deregister_style($name);

    wp_enqueue_style($name, $src, $dependencies, $version, $media);
  }
}