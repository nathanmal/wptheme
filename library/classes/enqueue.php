<?php 

namespace WPTheme;

use WPTheme\Package;
use WPTheme\Settings;
use WPTheme\Component;

class Enqueue
{

  use \WPTheme\Traits\Singleton;

  /**
   * Hold script attributes
   * @var array
   */
  private static $script_attributes = array();


  /**
   * Enqueue class constructor
   */
  public function __construct()
  {
    // Enqueue theme assets
    add_action( 'wp_enqueue_scripts', array($this, 'enqueue') );

    // Apply attributes to style/script tags
    add_filter( 'script_loader_tag', array($this, 'attributes'), 10, 3 );

    // remove WP version from css
    // add_filter( 'style_loader_src', array($this, 'unversion'), 9999 );

    // remove Wp version from scripts
    // add_filter( 'script_loader_src', array($this, 'unversion'), 9999 );

    
  }


  /**
   * Enqueue theme assets
   * @return [type] [description]
   */
  public function enqueue()
  {
    // Replace jQuery
    wp_deregister_script( 'jquery' );

    // Enqueue jQuery v3.5.1
    wp_enqueue_script( 'jquery', '//code.jquery.com/jquery-3.5.1.min.js', '', '3.5.1', TRUE );

    // Bootstrap
    $bootstrap = '//cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js';
    wp_enqueue_script( 'bootstrap', $bootstrap, array('jquery'), '5.1.0', TRUE);

    $bootstrap = '//cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css';
    wp_enqueue_style( 'bootstrap', $bootstrap, '', '5.1.0');

    // Fontawesome
    $fontawesome = '//pro.fontawesome.com/releases/v5.10.0/css/all.css';
    wp_enqueue_style( 'fontawesome', $fontawesome,'','5.10.0');

    // Theme javascript
    wp_enqueue_script('wptheme', wpt_asset('dist/theme.js','template'), array('bootstrap'),'1.0.0',TRUE);

    // Theme stylesheet
    wp_enqueue_style('wptheme', wpt_asset('dist/theme.css','template'), array('bootstrap'));


    // Select 2
    wp_register_style( 'wpt-select2', '//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', '', '4.1.0');
    wp_register_script( 'wpt-select2', '//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', '', '4.1.0', TRUE);
    wp_register_style( 'wpt-select2-bs', '//cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css', array('wpt-select2'));

    // Make sure this function is included
    if ( ! function_exists('is_plugin_active') ) 
    {
      include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    // If using classic editor, disable block library
    if( is_plugin_active('classic-editor/classic-editor.php') )
    {
      wp_dequeue_style( 'wp-block-library' );
    }
  }


  /**
   * Remove versioning from script
   * @param  string $src [description]
   * @return [type]      [description]
   */
  public function unversion( string $src )
  {
    return strpos( $src, 'ver=' ) ? remove_query_arg( 'ver', $src ) : $src;
  }


  /**
   * Adds ability to include custom attributes on enqueued script tags
   * @param [type] $tag    [description]
   * @param [type] $handle [description]
   * @param [type] $src    [description]
   */
  public function attributes( $tag, $handle, $src )
  {
    if( isset($this->script_attributes[$handle]) && ! empty($this->script_attributes[$handle]) )
    {
      $attr = '';

      foreach( $this->script_attributes[$handle] as $key => $value )
      {
        if( $key == 'src' ) continue;

        $attr .= (is_int($key) ? $value : $key .'="'.$value.'"') . ' ';
      }

      $tag = str_replace('src=', $attr . ' src=', $tag);
    }

    return $tag;
  }


  /**
   * Enqueue a script
   * @param  string $handle [description]
   * @param  string $src    [description]
   * @param  array  $attr   [description]
   * @return [type]         [description]
   */
  public function script( string $handle, string $source, array $dep = [], string $version = '', array $attr = [] )
  {
    if( $script = $this->uri($source) )
    {
      wp_enqueue_script( $handle, $script, $dep, $version, TRUE );
    }
  }

  /**
   * Enqueue a style
   * @param  string $handle [description]
   * @param  string $src    [description]
   * @return [type]         [description]
   */
  public function style( string $handle, string $source, array $dep = [], string $version = '', string $media = 'all' )
  {
    if( $style = $this->uri($source) )
    {
      wp_enqueue_style( $handle, $style, $dep, $version, $media );
    }
  }
  
  /**
   * Enqueue Google Font
   * @param  [type] $family   [description]
   * @param  array  $variants [description]
   * @return [type]           [description]
   */
  public function gfont( $family, $variants = array() )
  { 
    // google fonts API
    $src  = 'https://fonts.googleapis.com/css?family=' . $family;

    // add variants
    if( ! empty($variants) && is_array($variants) ) $src .= ':' . implode(',', $variants);
    
    // enqueue the font
    $this->font( $family, $src );
  }



  /**
   * Enqueue a font
   * @param  string $family [description]
   * @param  string $src    [description]
   * @return [type]         [description]
   */
  public function font( string $family, string $src )
  {

    $src = $this->src( $src, 'fonts' );
    // if not absolute URL then assume local path
    if( strpos($src, 'http') !== 0 ) $src = THEME_URI . '/assets/fonts/' . $src;

    // enqueue font
    Enqueue::style( 'font-' . strtolower($family), $src );
  }



  public function customizations()
  {
    // Enqueue customization stylesheet if it exists
    $uploads = wp_get_upload_dir();

    $file = $uploads['basedir'] . '/wptheme/customized.css';
    $url  = $uploads['baseurl'] . '/wptheme/customized.css';

    if( file_exists($file) )
    {
      $this->style('wptheme-customized', $url, array('wptheme') );
    }

  }


  public function path( string $path )
  {
    // Check for external paths
    if( 0 === strpos($path, 'http') )
    {
      return $path;
    }

    // Check stylesheet path
    if( is_file( STYLESHEETPATH . '/' . $path ) )
    {
      return STYLESHEETPATH . '/' . $path;
    }

    // Check template path
    if( is_file( TEMPLATEPATH . '/' . $path ) )
    {
      return TEMPLATEPATH . '/' . $path;
    }

    // Nothing found
    return '';
  }



  /**
   * Get source for asset 
   * @param  [type] $src  [description]
   * @param  string $path [description]
   * @return [type]       [description]
   */
  public function uri( string $path )
  {
    // Check for external paths
    if( 0 === strpos($path, 'http') )
    {
      return $path;
    }

    // Check stylesheet path
    if( is_file( STYLESHEETPATH . '/' . $path ) )
    {
      return get_stylesheet_directory_uri() . '/' . $path;
    }

    // Check template path
    if( is_file( TEMPLATEPATH . '/' . $path ) )
    {
      return get_template_directory_uri() . '/' . $path;
    }

    // Nothing found
    return '';
  }



  /**
   * Display enqueue files
   * @category utility
   * @return [type] [description]
   */
  public function debug() 
  {
    global $wp_scripts, $wp_styles;
    
    echo '<h3>Scripts</h3>';

    foreach( $wp_scripts->queue as $script )
    { 
      echo $script . '<br/>';
    }

    echo '<h3>Styles</h3>';

    foreach( $wp_styles->queue as $style )
    {
      echo $style . '<br/>';
    }
  }



  
}

Enqueue::instance();