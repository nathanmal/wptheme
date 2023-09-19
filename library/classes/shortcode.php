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


  public static function register()
  {
    $shortcodes = apply_filters( 'wpt_shortcodes', [
      '\\WPTheme\\Lipsum' => WPT_LIB . '/classes/shortcode/lipsum.php',
      '\\WPTheme\\Partial' => WPT_LIB . '/classes/shortcode/partial.php'
    ]);

    foreach($shortcodes as $class => $file)
    {
      include_once $file;

      $shortcode = new $class;

      $tag = $shortcode->getTag();

      if( ! shortcode_exists($tag) )
      {
        add_shortcode( $tag, [$shortcode, 'run'] );
      }
    }
  }

  /**
   * Shortcode constructor
   */
  public function __construct()
  {
    // Create slug if it is empty
    if( empty($this->tag) )
    {
      $this->tag = strtolower(wpt_class_shortname($this));
    }

    // Set shortcode tag
    $this->tag = wpt_prefix($this->tag, 'wpt_');
  }


  /**
   * Run the shortcode
   * @return [type] [description]
   */
  public function run( $attributes, $content, $tag ){}
}