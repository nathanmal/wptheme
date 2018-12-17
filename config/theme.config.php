<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Main theme configuration array
 */

return array(
  
  /**
   * JavaScript files to be pre-loaded into the theme
   *
   * Each script config should be an array with the key name being the script name 
   * and the data specifying the attributes used in wp_enqueue_script
   *
   * example:
   *
   *  'myscript' => array(
   *    'source' => relative/to/assets/source.js,
   *    'dependencies' => array('of','dependencies'),
   *    'version' => '0.2.1',
   *    'footer' => TRUE/FALSE whether to load in footer of page
   *  )
   *  
   */
  'scripts' => array(),

  /**
   * CSS StyleSheets to be pre-loaded into the theme
   *
   * Like scripts, stylesheets are specified by arrays and supply the arguments used
   * for wp_enqueue_style
   *
   * example:
   *
   *  'bootstrap' => array(
   *    'source'  => THEME_URI . '/assets/vendor/bootstrap/dist/css/bootstrap.min.css',
   *    'dependencies' => array('jquery'),
   *    'version' => '4.0.0',
   *    'media' => 'screen'
   *  )
   *
   */
  'styles' => array(),

  /**
   * Theme font files
   *
   * Specify the font names and absolute URLs to the file stylesheets
   *
   * example:
   *
   *  'fonts' => array(
   *    'abril' => 'https://fonts.googleapis.com/css?family=Abril+Fatface',
   *    'opensans' => 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800',
   *  ),
   * 
   */
  'fonts' => array(),

  /**
   * Theme menus. Add custom menus here. Can add more via /theme/theme.config.php
   *
   * defaults:
   *
   *  'main-menu'   => __( 'Main Menu', THEME_DOMAIN ),     // main nav 
   *  'mobile-menu' => __( 'Mobile Menu', THEME_DOMAIN ),   // mobile nav 
   *  'footer-menu' => __( 'Footer Menu', THEME_DOMAIN )    // footer nave
   *
   * @see    https://developer.wordpress.org/reference/functions/wp_nav_menu/ 
   */
  'menus' => array(
  ),

  
  /**
   * Theme sidebars. Add custom sidebars here
   *
   * default:
   *
   *  array(
   *    'id'            => 'main',
   *    'name'          => __( 'Main Sidebar', THEME_DOMAIN ),
   *    'description'   => __( 'The main sidebar.', THEME_DOMAIN ),
   *    'before_widget' => '<div id="%1$s" class="widget %2$s">',
   *    'after_widget'  => '</div>',
   *    'before_title'  => '<h4 class="widgettitle">',
   *    'after_title'   => '</h4>',
   *  )
   *
   * @see https://codex.wordpress.org/Function_Reference/register_sidebar 
   */
  'sidebars' => array(),

  /**
   * Enable Widgets
   */
  'widgets' => array(),

  /**
   * Enable shortcodes
   */
  'shortcodes' => array('lipsum'),

);