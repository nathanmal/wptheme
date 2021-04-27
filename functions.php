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

// Composer autoloader
require_once('library/vendor/autoload.php');

// Theme autoloader
require_once('library/autoload.php');

// Register theme autoloader
spl_autoload_register( 'wptheme_autoload' );

// Helper functions
require_once('library/helpers.php');

// Hook into WP theme init
add_action( 'init', array('WPTheme\\Theme', 'init') );