<?php 

namespace WPTheme;

use WPTheme\Package;
use WPTheme\Settings;
use WPTheme\Component;

class Enqueue
{


  /**
   * Enqueue installed package
   * @param  [type] $name [description]
   * @return [type]       [description]
   */
  public static function package( $name )
  {

    $source = Settings::get('package.source', 'local');

    if( $source == 'local' )
    {
      $base = THEME_URI .'/assets/package/' . $name;
    }
    else if( $source == 'cdn' )
    {
      $base = Package::url($name);
    }
    else
    {
      return FALSE;
    }


    $package = Package::get($name);

    // Must exist
    if( empty($package) ) 
    {
      Enqueue::error('Package empty: ' . $name);
      return FALSE;
    }

    if( ! element($package, 'enabled', FALSE) )
    {
      Enqueue::error('Package not enabled: ' . $name);
      return FALSE;
    }
    
    $includes = element( $package, 'includes', array() );
    $version  = element( $package, 'version', '');

    foreach($includes as $index)
    {
      $file = element($package['files'], $index, FALSE);

      if( empty($file) ) continue;

      $src = $base . '/' . $version . '/' . $file;

      $ext = pathinfo($file, PATHINFO_EXTENSION);
      // $f = pathinfo($file, PATHINFO_FILENAME);

      switch($ext)
      {
        case 'js':
          Enqueue::script( $name, $src, $version );
          break;

        case 'css':
          Enqueue::style( $name, $src, $version );
          break;

        default:
          Enqueue::error( 'Unknown file extension: ' . $ext );
          break;
      }
    }


  }

  /**
   * Enqueue Google Font
   * @param  [type] $family   [description]
   * @param  array  $variants [description]
   * @return [type]           [description]
   */
  public static function googlefont( $family, $variants = array() )
  {
    $name = 'font-' . strtolower($family);
    
    $src  = 'https://fonts.googleapis.com/css?family=' . $family;

    if( ! empty($variants) )
    {
      $src .= ':' . implode(',', $variants);
    }

    Enqueue::style( $name, $src );
  }

  /**
   * Enqueue Google Font
   * @param  [type] $family   [description]
   * @param  array  $variants [description]
   * @return [type]           [description]
   */
  public static function font( $family, $variants = array() )
  {
    $name = 'font-' . strtolower($family);
    $src  = 'https://fonts.googleapis.com/css?family=' . $family;

    if( ! empty($variants) )
    {
      $src .= ':' . implode(',', $variants);
    }

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
  public static function script( $name, $src, $version = '', $dep = array(), $footer = TRUE )
  {

    if( strpos($src, 'http') !== 0 )
    {
      $src = THEME_ENV === 'production' ? 'https://cdnjs.cloudflare.com/ajax/libs/' . $src : THEME_URI . '/assets/vendor/' . $src;
    }

    wp_deregister_script($name);
    wp_enqueue_script($name, $src, $dep, $version, $footer);
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
  public static function style( $name, $src, $version = '', $dep = array(), $media = 'all' )
  {
    if( strpos($src, 'http') !== 0 )
    {
      $src = THEME_ENV === 'production' ? 'https://cdnjs.cloudflare.com/ajax/libs/' . $src : THEME_URI . '/assets/vendor/' . $src;
    }

    wp_deregister_style($name);
    wp_enqueue_style($name, $src, $dep, $version, $media);
  }
}