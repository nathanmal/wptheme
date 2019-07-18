<?php if ( ! defined( 'ABSPATH' ) ) exit('Foolish Mortal!'); 
/*
Author: Nathan Malachowski
URL: http://ntheory.design

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

// Theme version
define('THEME_VERSION', '0.1.0');

// Theme debugging
define('THEME_DEBUG', TRUE);

// load helpers
require_once('library/helpers.php');

// load the main theme class
require_once('library/theme.php');

// Theme autoloader
spl_autoload_register( array('Theme','autoload') );

// Hook into WP theme activation
add_action( 'after_switch_theme', 'Theme::activate' );

// Hook into WP theme deactivation
add_action( 'switch_theme', 'Theme::deactivate' );

// Hook into WP theme init
add_action( 'init', 'Theme::init' );