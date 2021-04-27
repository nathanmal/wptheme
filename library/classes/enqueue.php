<?php 

namespace WPTheme;

use WPTheme\Package;
use WPTheme\Settings;
use WPTheme\Component;

class Enqueue
{

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
    // remove WP version from css
    add_filter( 'style_loader_src', array($this, 'unversion'), 9999 );

    // remove Wp version from scripts
    add_filter( 'script_loader_src', array($this, 'unversion'), 9999 );

    // Apply attributes to style/script tags
    add_filter( 'script_loader_tag', array($this, 'attributes'), 10, 3 );

    // Enqueue theme scripts
    add_action( 'wp_enqueue_scripts', array($this, 'scripts'));
  }


  public function scripts()
  {
    $plugins = get_option( 'active_plugins', array());

    // Remove block library if using classic
    if( in_array( 'classic-editor/classic-editor.php', $plugins, true ) )
    {
      wp_dequeue_style( 'wp-block-library' );
    }
  
    $this->script('wptheme', wpt_url('assets/dist/theme.js'));
    $this->style('wptheme', wpt_url('assets/dist/theme.css'));

    if( wpt()->has_child )
    {
      $this->script('wptheme-child', get_stylesheet_directory_uri() . '/assets/dist/child.js', array('wptheme'));
      $this->style('wptheme-child', get_stylesheet_directory_uri() . '/assets/dist/child.css',array('wptheme'));
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
  public function script( string $handle, string $src, array $attr = [] )
  {
    wp_enqueue_script( $handle, $this->src($src), array(), NULL, TRUE );
  }

  /**
   * Enqueue a style
   * @param  string $handle [description]
   * @param  string $src    [description]
   * @return [type]         [description]
   */
  public function style( string $handle, string $src )
  {
    wp_enqueue_style( $handle, $this->src($src) );
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


  /**
   * Get source for asset 
   * @param  [type] $src  [description]
   * @param  string $path [description]
   * @return [type]       [description]
   */
  public function src( $src, $path = '' )
  {
    // Check for external paths
    if( 0 === strpos($src, 'http') ) return $src;

    // Check stylesheet path
    if( is_file( STYLESHEETPATH . '/assets/' . $src ) )
    {
      return STYLESHEETPATH . '/assets/' . $src;
    }

    // Check template path
    if( is_file( TEMPLATEPATH . '/assets/' . $src ) )
    {
      return TEMPLATEPATH . '/assets/' . $src;
    }

    // Nothing found
    return FALSE;
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