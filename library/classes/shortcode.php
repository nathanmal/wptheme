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
    if( empty($this->tag) )
    {
      $this->tag = strtolower(wpt_shortname($this));
    }

    // Set shortcode tag
    $this->tag = wpt_prefix($this->tag, 'wpt_');

    // Register the shortcode
    $this->register();
  }

  /**
   * Register shortcode
   * @return [type] [description]
   */
  public function register()
  {
    if( ! shortcode_exists($this->tag) )
    {
      add_shortcode( $this->tag , array($this, 'run') );
    }
  }

  /**
   * Run the shortcode
   * @return [type] [description]
   */
  public function run( $attributes, $content, $tag ){}
}