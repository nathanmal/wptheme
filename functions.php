<?php if ( ! defined( 'ABSPATH' ) ) exit; 
/*
Author: Nathan Malachowski
URL: http://ntheorydesign.com

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, etc.
*/

// Path to theme dir
define('THEME_DIR', get_template_directory());

// URI to theme 
define('THEME_URI', get_template_directory_uri());

// Path to theme library folder
define('THEME_LIB', THEME_DIR . '/library');

// Environment we're using development|staging|production
define('THEME_ENV', 'development');

// Theme text domain name
define('THEME_DOMAIN', 'wptheme');

// load the main theme class
require_once('library/theme.php');

// Hook into WP theme activation
add_action( 'after_switch_theme', 'Theme::activate' );

// Hook into WP theme deactivation
add_action( 'switch_theme', 'Theme::deactivate' );

// Hook into WP theme init
add_action( 'after_setup_theme', 'Theme::init' );


// Anything below is custom code
// ================================================================================
// ================================================================================
