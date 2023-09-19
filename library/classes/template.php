<?php

namespace WPTheme;

final class Template
{

  use \WPTheme\Traits\Singleton;

  /**
   * Built in wordpress templates
   * @var [type]
   */
  public $templates = [
    '404',
    'search',
    'frontpage',
    'home',
    'privacypolicy',
    'taxonomy',
    'attachment',
    'single',
    'page',
    'singular',
    'category',
    'tag',
    'author',
    'date',
    'archive',
    'search',
    'index'
  ];

  /**
   * Template type
   * @var string
   */
  public $type = '';

  /**
   * The template file path
   * @var string
   */
  public $path = '';

  /**
   * Constructor
   *
   * Adds template filter
   */
  public function __construct()
  {

    $priority = 1;


    // 404 Template
    add_filter( '404_template', array($this, 'notfound'), $priority, 3);

    // Frontpage template
    add_filter( 'frontpage_template', array($this, 'frontpage'), $priority, 3);
 
    // Pages
    add_filter( 'page_template', array($this, 'page'), $priority, 3 );

    // Search results page
    add_filter( 'search_template', array($this, 'search'), $priority, 3);

    // Archive pages
    add_filter( 'archive_template', array($this, 'archive'), $priority, 3);

    // Category template
    add_filter( 'category_template', array($this, 'category'), $priority, 3);

    // Generic taxonomy template
    add_filter( 'taxonomy_template', array($this, 'taxonomy'), $priority, 3);

    // Single post templates
    add_filter( 'single_template', array($this, 'single'), $priority, 3);

    // Override template include
    add_filter( 'template_include', array($this, 'include'), 10, 1);

    // Manage theme template directory
    add_filter( 'theme_page_templates', array( $this, 'page_templates'), $priority, 4);
  }

  /**
   * Set template to include
   * @param  [type] $template [description]
   * @return [type]           [description]
   */
  public function include( $template )
  {
    $this->path = $template;
    $this->type = pathinfo($template, PATHINFO_FILENAME);
    return $template;
  }

  /**
   * 404 Template
   * @param  [type] $template [description]
   * @return [type]           [description]
   */
  public function notfound( $template )
  { 
    return $template;
  }


  /**
   * Front page template
   * @param  [type] $template [description]
   * @return [type]           [description]
   */
  public function frontpage( $template )
  {
    if( $found = locate_template( 'templates/front.php' ) )
    {
      return $found;
    }

    return $template;
  }

  /**
   * Load custom page template
   * @param  [type] $template [description]
   * @return [type]           [description]
   */
  public function page( $template )
  {
    // Get the current post ID
    $post_id = get_the_ID();

    // Get the current post slug
    $slug = get_page_uri($post_id);

    // Check pages directory for page
    if( $found = locate_template('templates/page/' . $slug . '.php') )
    {
      return $found;
    }

    // Check for generic page template
    if( $found = locate_template('templates/page.php') )
    {
      return $found;
    }

    // Use wp default location
    return $template;

  }

  /**
   * Search results page
   * @param  [type] $template [description]
   * @return [type]           [description]
   */
  public function search( $template )
  {
    if( $found = locate_template('templates/search.php') )
    {
      return $found;
    }

    return $template;
  }

  /**
   * Load custom archive template
   * @param  [type] $template [description]
   * @return [type]           [description]
   */
  public function archive( $template )
  {
    // Get the post type
    $type = $this->get_post_type();

    if( $type && is_post_type_archive($type) )
    {
      if( $found = locate_template( 'templates/archive/' . $type . '.php') )
      {
        return $found;
      }
    }

    // Check for archive template
    if( $found = locate_template( 'templates/archive.php') )
    {
      return $found;
    }

    return $template;
  }


  /**
   * Category template
   * @param  [type] $template [description]
   * @return [type]           [description]
   */
  public function category( $template )
  {
    $category = get_the_category();

    if( $category && $found = locate_template( 'templates/category/' . $category .'.php') )
    {
        return $found;
    }

    return $template;
  }

  /**
   * Taxonomy template
   * @param  [type] $template [description]
   * @return [type]           [description]
   */
  public function taxonomy( $template )
  {
    $taxonomy = get_query_var( 'taxonomy' );

    $term = get_query_var( 'term' );

    if( $taxonomy && $found = locate_template( 'templates/taxonomy/' . $taxonomy .'.php') )
    {
        return $found;
    }

    return $template;

  }

  /**
   * Load custom single post template
   * @param  [type] $template [description]
   * @return [type]           [description]
   */
  public function single( $template )
  {
    // Get the current post ID
    $post_id = get_the_ID();

    // Get the post type
    $type = get_post_type($post_id);

    // Check for template that matches post type
    if( $type && $found = locate_template( 'templates/single/' . $type . '.php' ) )
    {
      return $found;
    }

    // Check for single post template
    if( $found = locate_template('templates/single.php') )
    {
      return $found;
    }

    return $template;
  }

 

  /**
   * Load theme templates
   * 
   * Wordpress has a hard time with this because it's default depth search is
   * only 1 directory, so we gotta do it manually here
   *
   * Hook: theme_page_templates
   * @see https://developer.wordpress.org/reference/hooks/theme_page_templates/
   * 
   * @param  [type] $templates [description]
   * @param  [type] $theme     [description]
   * @param  [type] $post      [description]
   * @param  [type] $post_type [description]
   * @return [type]            [description]
   */
  public function page_templates( $templates, $theme, $post, $post_type )
  {
    $files = glob( get_template_directory() . '/templates/*.php' );

    foreach($files as $file)
    { 
      $content = file_get_contents($file);

      // Skip if file doesn't have 
      if ( ! preg_match( '|Template Name:(.*)$|mi', $content, $header ) ) continue;

      $template = 'templates/' . $file;

      $templates[$template] = _cleanup_header_comment( $header[1] );

    }

    return $templates;
  }


  private function get_post_type()
  {
    // Get the current post ID
    $post_id = get_the_ID();

    // Check post for post type
    if( $post_id )
    {
      return get_post_type($post_id);
    }

    // Check query vars for post type
    if( $post_type = get_query_var('post_type') )
    {
      return $post_type;
    }

    // No post type found
    return '';

  }


  /**
   * Get the template path
   * @return [type] [description]
   */
  public function getPath()
  {
    return $this->path;
  }

  /**
   * Get the template type
   * @return [type] [description]
   */
  public function getType()
  {
    return $this->type;
  }

}