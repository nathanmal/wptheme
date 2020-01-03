<?php 

namespace WPTheme;

use WPTheme\Theme;
use WPTheme\Component;

class Package extends Component
{ 
  private static $api_url = 'https://api.cdnjs.com/libraries';


  private static $api_lib = 'https://cdnjs.cloudflare.com/ajax/libs';

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


  /**
   * Import and download package
   * @param  [type] $name    [description]
   * @param  string $version [description]
   * @return [type]          [description]
   */
  public static function import( $name, $version = 'latest' )
  {
    $info = Package::info($name);

    $packages = Settings::get('packages.installed', array());

    if( isset($packages[$name]) )
    {
      Package::error('Package already imported: ' . $name);

      return FALSE;
    }

    if( empty($info) )
    {
      Package::error('Could not load package info: ' . $name );

      return FALSE;
    }

    $version = $version == 'latest' ? $info->version : $version;

    $releases = array();

    foreach( $info->assets as $release )
    {
      $releases[$release->version] = $release->files;
    }

    if( ! isset($releases[$version]) )
    {
      Package::error('Could not find release version ' . $version );

      return FALSE;
    }

    $package = array(
      'name'         => $name,
      'version'      => $version,
      'latest'       => ( $info->version === $version ),
      'files'        => $releases[$version],
      'info'         => $info,
      'enabled'      => FALSE,
      'footer'       => TRUE, 
      'dependencies' => array()
    );

    $enqueued = array();

    foreach($releases[$version] as $file)
    {
      $enqueued[$file] = FALSE;
    }

    $package['enqueued'] = $enqueued;
   
    // Download package to local assets and save 
    if( ! Package::download( $name, $version ) )
    {
      Package::error('Could not download package assets');

      return FALSE;
    }

    // Add to array
    $packages[$name] = $package;

    // Update imported packages
    $updated = Settings::update('packages.installed', $packages);

    if( ! $updated )
    {
      Package::error('Could not update setting');
      return FALSE;
    }

    return TRUE;
    
  }

  /**
   * Remove a package
   * @param  [type] $name [description]
   * @return [type]       [description]
   */
  public static function remove( $name )
  {
    $packages = Settings::get('packages.installed', array());

    if( isset($packages[$name]) )
    {
      Package::delete( $name );

      unset($packages[$name]);
    }
    else
    {
      Package::error('Package not installed: ' . $name );
      return FALSE;
    }

    if( Settings::update('packages.installed', $packages) )
    {
      return TRUE;
    }

    Package::error('Could not update package settings');
    return FALSE;
  }

  /**
   * Search packages on CDNjs API
   * @param  [type] $query [description]
   * @return [type]        [description]
   */
  public static function search( $query )
  {
    if( empty($query) ) return array();

    $searches = Theme::cache( 'cdnjs-searches' );

    if( ! empty($searches) && isset($searches[$query]) )
    {
      return $searches[$query];
    } 

    $url = Package::$api_url . '?search=' . urlencode($query) . '&fields=version,description,license';

    $json = file_get_contents($url);

    if( ! empty($json) )
    {
      $data = json_decode($json);

      if( empty($searches) ) $searches = array();

      $searches[$query] = $data;

      Theme::cache( 'cdnjs-searches', $searches );

      return $data;
    }

    return array();
   
  }


  /**
   * Get info about package via CDNjs API
   * @param  [type] $package [description]
   * @return [type]          [description]
   */
  public static function info( $package )
  {
    if( empty($package) ) return array();

    $packages = Theme::cache( 'cdnjs-packages' );

    if( ! empty($packages) && isset($packages[$package]) )
    {
      return $packages[$package];
    }

    $url = Package::$api_url . '/' . $package;

    $json = file_get_contents($url);

    if( ! empty($json) )
    {
      // Decode
      $data = json_decode($json);

      if( empty($packages) ) $packages = array();

      $packages[$package] = $data;

      // Cache the package data
      Theme::cache( 'cdnjs-packages', $packages );

      return $data;
    }

    return array();

  }

  /**
   * Download CDN package to local filesystem
   * @param  [type] $package [description]
   * @param  [type] $version [description]
   * @return [type]          [description]
   */
  public static function download( $package, $version )
  {
    $base = THEME_DIR . '/assets/package';

    $dir  = $base . '/' . $package . '/' . $version;

    if( ! is_dir($dir) )
    {
      if( ! wp_mkdir_p( $dir ) ) 
      {
        Theme::error( 'Could not create directory: ' . $dir, __CLASS__, __LINE__ );

        return FALSE;
      }
    }

    $data = Package::info($package);

    if( empty($data) OR ! isset($data->assets) OR empty($data->assets) )
    {
      Theme::error('No API data for package ' . $package, __CLASS__, __LINE__  );

      return FALSE;
    }

    $files = FALSE;

    foreach($data->assets as $asset)
    {
      if( $asset->version == $version )
      {
        $files = $asset->files;
        break;
      }
    }

    if( ! $files OR empty($files) )
    {
      Theme::error('Could not find assets for package "' . $package . '" at version ' . $version, __CLASS__, __LINE__ );

      return FALSE;
    }

    $base = Package::$api_lib . '/' . $package . '/' . $version;

    foreach($files as $file)
    {
      $url = $base . '/' . $file;

      $destination = $dir . '/' . $file;

      $path = dirname($destination);

      if( ! is_dir($path) ) wp_mkdir_p($path); 

      file_put_contents( $destination, file_get_contents($url) );
    }




    return TRUE;




  }

  /**
   * Delete package files
   *
   * @param  [type] $package [description]
   * @param  [type] $version [description]
   * @return [type]          [description]
   */
  public static function delete( $name, $version = NULL)
  {
    $dir = THEME_DIR . '/assets/package/' . $name;

    if( ! empty($version) )
    {
      $dir .= '/' . $version;
    }

    if( WP_Filesystem() )
    {
      global $wp_filesystem; 

      if( ! is_dir($dir) )
      {
        Package::error('Directory does not exist: ' . $dir );
        return FALSE;
      }

      if( ! $wp_filesystem->rmdir($dir, TRUE) )
      {
        Package::error('Could not delete directory: ' . $dir);
        return FALSE;
      }

      return TRUE;
    }
   
    Package::error('Could not load filesystem class');
    
    return FALSE;
    
  }


  public static function get( $name )
  {
    $packages = Settings::get('packages.imported');

    if( ! isset($packages[$name]) )
    {
      Package::error('Package not imported');

      return FALSE;
    }

    return $packages[$name];


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


  public static function url( $name )
  {
    return Package::$api_lib . '/' . $name;
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