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
define('THEME_VERSION', '0.6.0');

// Theme debugging
define('THEME_DEBUG', TRUE);

// load theme constants
require_once('config/constants.php');

// load helpers
require_once('library/autoload.php');

// load helpers
require_once('library/helpers.php');

// Theme autoloader
spl_autoload_register( 'wptheme_autoload' );

// Hook into WP theme activation
add_action( 'after_switch_theme', 'WPTheme\\Theme::activate' );

// Hook into WP theme deactivation
add_action( 'switch_theme', 'WPTheme\\Theme::deactivate' );

// Hook into WP theme init
add_action( 'init', array('WPTheme\\Theme', 'init') );