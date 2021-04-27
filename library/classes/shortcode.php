<?php
/**
 * Shortcode class
 *
 * Provides a base class for adding new shortcodes.
 * Shortcode class tags default to their lowercase short class name.
 * The 'run' method must be implemented in the subclass to process the shortcode content
 * 
 */
namespace WPTheme;


class Shortcode
{

  /**
   * If shortcode is enabled
   * @var boolean
   */
  public $enabled = TRUE;


  /**
   * The shortcode slug
   * @var string
   */
  public $slug = '';


  /**
   * The shortcode tag used for WP
   * @var string
   */
  public $tag = '';


  /**
   * Shortcode constructor
   */
  public function __construct()
  {
    // Create slug if it is empty
    if( empty($this->slug) )
    {
      $this->slug = strtolower(wpt_shortname($this));
    }

    // Set shortcode tag
    $this->tag = 'wpt:' . $this->slug;
  }

  /**
   * Register shortcode
   * @return [type] [description]
   */
  public function register()
  {
    // Only register if enabled
    if( ! $this->enabled ) return;

    if( shortcode_exists($this->tag) )
    {
      wp_die('Shortcode already registered: ' . $this->tag);
    }
    
    add_shortcode( $this->tag , array($this, 'run') );

    
  }

  /**
   * Run the shortcode
   * @return [type] [description]
   */
  public function run( array $attributes, string $content, string $tag ){}
}