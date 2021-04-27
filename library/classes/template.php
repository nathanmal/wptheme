<?php

namespace WPTheme;

class Template
{




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
    foreach( $this->templates as $template )
    {
      // add_filter($template .'_template', [$this,'locate'],10,3);
    }
 
    // Pages
    add_filter( 'page_template', array($this, 'page'), 10, 3 );

    // Archive pages
    add_filter( 'archive_template', array($this, 'archive'), 10, 3);

    // Single post templates
    add_filter( 'single_template', array($this, 'single'), 10, 3);

    // Manage theme template directory
    add_filter( 'theme_page_templates', array( $this, 'page_templates'), 10, 4);
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
    if( $found = locate_template( 'views/pages/' . $slug . '.php' ) )
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
    // Get the current post ID
    $post_id = get_the_ID();

    // Get the post type
    $type = get_post_type($post_id);


    if( $type && is_post_type_archive($type) )
    {
      if( $found = locate_template( 'views/archive/' . $type . '.php') )
      {
        return $found;
      }
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

    if( $type && $found = locate_template( 'views/single/' . $type . '.php' ) )
    {
      return $found;
    }

    return $template;
  }



  /**
   * Locate template based on type
   * @param  [type] $template  [description]
   * @param  [type] $type      [description]
   * @param  [type] $templates [description]
   * @return [type]            [description]
   */
  public function locate( $template, $type, $templates )
  {
    // Set template path
    $this->path = $template;

    // Set template type
    $this->type = $type;

    // Get the current post ID
    $post_id = get_the_ID();

    // Get the current post type
    $post_type = get_post_type($post_id);

    // Get the current post slug
    $post_slug = get_page_uri($post_id);


    switch($type)
    {
      case 'page':

        // Search for page slug template
        if( $found = $this->find('pages/'.$post_slug) ) break;

        // Search for page template
        $found = $this->find('page');

        break;

      case 'frontpage':

        // Search for front template
        $found = $this->find('front');

        break;

      default:
        // Search for template by type
        $found = $this->find($type);
        break;
    }

    // Check if we found a template file
    if( ! empty($found) )
    {
      // Update template path
      $this->path = $found;

      return $found;
    }


    return $template;
  }

  /**
   * Find template file
   * @param  string $path [description]
   * @return [type]       [description]
   */
  public function find( string $path )
  {
    // Add php extension if needed
    $path = wpt_suffix($path, '.php');

    // Add views directory if needed
    $path = wpt_prefix($path, 'views/');

    // Use built in locate_template function
    return locate_template( array($path) );
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
    $files = glob(THEME_DIR.'/views/templates/*.php');

    foreach($files as $file)
    { 
      $content = file_get_contents($file);

      // Skip if file doesn't have 
      if ( ! preg_match( '|Template Name:(.*)$|mi', $content, $header ) ) continue;

      $template = 'views/templates/' . $file;

      $templates[$template] = _cleanup_header_comment( $header[1] );

    }

    return $templates;
  }

}