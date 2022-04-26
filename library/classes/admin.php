<?php 

namespace WPTheme;

use WPTheme\Theme;
use WPTheme\Enqueue;
use WPTheme\Ajax;
use WPTheme\Admin\Page;

class Admin
{

  /**
   * Settings pages
   * @var array
   */
  private $pages = array();


  /**
   * Current page slug
   * @var string
   */
  private $slug = '';


  /**
   * Admin constructor
   */
  public function __construct()
  {
    // Load admin settings
    $this->load_pages();

    // Get the current settings page
    $this->slug = $_GET['page'] ?? NULL;

    // Add menu
    add_action( 'admin_menu', array( $this, 'menu'), 10 );

    // Enqueue plugin admin scripts
    add_action( 'admin_enqueue_scripts', array( $this , 'enqueue'), 10 );
  }


  /**
   * Load theme settings pages
   * @return [type] [description]
   */
  public function load_pages()
  { 
    $dir = THEME_LIB . '/classes/admin/page';

    if( ! function_exists('list_files') ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
  
    $files = list_files($dir, 2);

    foreach($files as $file)
    {
      // Ignore non-php files
      if( pathinfo($file, PATHINFO_EXTENSION) !== 'php' ) continue;

      $path = substr(substr($file, strlen($dir)), 0, -4);

      $parts = explode('/', $path);

      $class = '\\WPTheme\\Admin\\Page' . implode('\\', array_map('ucfirst',$parts));

      if( class_exists($class) )
      {
        $page = new $class();

        $this->pages[$page->slug] = $page;
      }
      else
      {
        wp_die('Class does not exist: '  . $class);
      }
    }
  }

  /**
   * Enqueue admin scripts
   * @return [type] [description]
   */
  public function enqueue()
  {
    wp_enqueue_script('wpt-admin', wpt_asset('assets/dist/admin.js'), array('jquery'), FALSE, TRUE );

    wp_enqueue_style('wpt-admin', wpt_asset('assets/dist/admin.css') );
  }



  /**
   * Add admin menu items
   * @return [type] [description]
   */
  public function menu()
  {
    // Main plugin menu
    add_menu_page(
      'WPTheme',
      'WPTheme',
      'manage_options',
      'wptheme',
      array( $this, 'process' ), 
      NULL, // Icon
      '79'
    );

    foreach($this->pages as $page)
    {
      if( ! $page->enabled ) continue;

      add_submenu_page(
        'wptheme',
        $page->title,
        $page->menu_title,
        $page->capability,
        $page->slug,
        array($this, 'process')
      );
    }
  }


  public function page()
  {
    return $this->pages[$this->slug] ?? FALSE;
  }


  /**
   * Process page saving and rendering
   * @return [type] [description]
   */
  public function process()
  { 
    // Check slug
    if( ! $this->page() )
    {
      wp_die('Invalid settings page');
    }

    // Process current page
    $this->page()->process();

    ?>
    <div id="wpt-settings" class="wrap">
      <?php $this->render_header(); ?>
      <?php $this->render_page(); ?>
    </div>
    <?php
      
  }

  /**
   * Render settings page header
   * @return [type] [description]
   */
  public function render_header()
  {
    ?>
    <header class="wpt-settings-header">
      <h1>
        <span class="wpt-settings-title">WPTheme</span>
        <span class="wpt-settings-subtitle"><?= $this->page()->title ?></span>
      </h1>
      <?php $this->render_navigation(); ?>
    </header>
    <?php
  }

  /**
   * Render settings navigation
   * @return [type] [description]
   */
  public function render_navigation()
  {
    ?>
    <ul class="wpt-settings-nav">
    <?php 

      foreach($this->pages as $slug => $page)
      {
        $active = ($slug == $this->slug);

        echo '<li class="' . ($active ? 'active' : '') .'">';
        echo '<a href="'. admin_url('admin.php?page='.$slug) .'">';
        echo $page->menu_title;
        echo '</a></li>';
      }
  
    ?>
    </ul>
    <?php
  }

  /**
   * Render the settings page
   * @return [type] [description]
   */
  public function render_page()
  { 
    ?>
    <!-- Begin settings page form -->
    <form id="wpt-settings-form" method="post" action="<?= $action ?>">
    <?php

    if( $this->slug && isset($this->pages[$this->slug]) )
    {
      $this->pages[$this->slug]->render();
    }

    ?>
    </form>
    <!-- End settings page form -->
    <?php
  }




}