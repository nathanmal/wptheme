<?php 

namespace WPTheme;

use WPTheme\Package;
use WPTheme\Settings;
use WPTheme\Component;

class Enqueue
{



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

  public static function script( $name, $src, $version = '', $dep = array(), $footer = TRUE )
  {
    wp_deregister_script($name);
    wp_register_script($name, $src, $version, $dep, $footer);
    wp_enqueue_script($name);
  }

  public static function style( $name, $src, $version = '', $dep = array(), $media = 'all' )
  {
    wp_deregister_style($name);
    wp_register_style($name, $src, $version, $dep, $media);
    wp_enqueue_style($name);
  }
}