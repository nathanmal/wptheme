<?php 

namespace WPTheme;

use WPTheme\Package;
use WPTheme\Settings;
use WPTheme\Component;

class Enqueue
{

  private static $theme_dependencies = array('bootstrap');


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
   * Enqueue theme base scripts & styles
   * @return [type] [description]
   */
  public static function theme()
  {
    Enqueue::jquery();
    Enqueue::bootstrap();

    // Enqueue theme scripts/styles
    Enqueue::script( 'wptheme', THEME_URI . '/assets/dist/theme.js',  Enqueue::$theme_dependencies, THEME_VERSION );
    Enqueue::style(  'wptheme', THEME_URI . '/assets/dist/theme.css', Enqueue::$theme_dependencies, THEME_VERSION );
  }

  /**
   * Enqueue jQuery
   * @return [type] [description]
   */
  public static function jquery()
  {
    $jquery = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js';
    Enqueue::script( 'jquery', $jquery, array(), '3.4.1', TRUE );
  }

  /**
   * Enqueue Bootstrap
   * @return [type] [description]
   */
  public static function bootstrap()
  {
    $bsjs = 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js';
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
      $src = THEME_URI . '/assets/fonts/' . $src;
    }

    $handle = 'font-' . strtolower($family);

    Enqueue::style( $handle, $src );
  }

  /**
   * Enqueue a theme dependent script
   * @param  [type]  $handle       [description]
   * @param  [type]  $src          [description]
   * @param  array   $dependencies [description]
   * @param  string  $version      [description]
   * @param  boolean $footer       [description]
   * @param  array   $attr         [description]
   * @return [type]                [description]
   */
  public static function dependency( $handle, $src, $dependencies = array(), $version = '', $footer = TRUE, $attr = array() )
  {
    if( ! in_array( $handle, Enqueue::$theme_dependencies) )
    {
      Enqueue::$theme_dependencies[] = $handle;
    }

    Enqueue::script( $handle, $src, $dependencies = array(), $version = '', $footer = TRUE, $attr = array() );
  }

  /**
   * Enqueue a script
   * @param  [type]  $handle    [description]
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
      $src = THEME_URI . '/' . $src;
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
   * @param  [type] $handle    [description]
   * @param  [type] $src     [description]
   * @param  string $version [description]
   * @param  array  $dep     [description]
   * @param  string $media   [description]
   * @return [type]          [description]
   */
  public static function style( $handle, $src, $dependencies = array(), $version = '', $media = 'all' )
  {
    if( strpos($src, 'http') !== 0 )
    {
      $src = THEME_URI . '/' . $src;
    }

    wp_deregister_style($handle);

    wp_enqueue_style($handle, $src, $dependencies, $version, $media);
  }
}