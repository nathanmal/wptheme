<?php if ( ! defined( 'ABSPATH' ) ) exit('Foolish Mortal!'); 

/*
Author: Nathan Malachowski
URL: http://ntheory.design

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, etc.
*/

// Path to theme dir
define('WPT_DIR', get_template_directory());

// URI to theme 
define('WPT_URI', get_template_directory_uri());

// Path to theme library folder
define('WPT_LIB', WPT_DIR . '/library');

// Environment we're using development|staging|production
define('WPT_ENV', 'development');

// Theme text domain name
define('WPT_DOMAIN', 'wptheme');

// Theme version
define('WPT_VERSION', '0.6.0');

// Composer autoloader
require_once('vendor/autoload.php');

// Core functions
require_once('functions.php');

// Load the theme class
wpt();