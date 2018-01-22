<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Main theme configuration array
 */

return array(
	
	// Scripts to be loaded in the theme
	'scripts' => array(
		// This replaces built in WP jQuery with 3.2.1 and should always be first
		'jquery' => array(
			'source' => THEME_URI . '/assets/vendor/jquery/dist/jquery.min.js',
			'version' => '3.2.1',
			'footer' => TRUE,
		),

		'bootstrap' => array(
			'source'       => THEME_URI .'/assets/vendor/bootstrap/dist/js/bootstrap.bundle.js',
			'dependencies' => array('jquery'),
			'version'      => '4.0.0',
			'footer'       => TRUE,
		),

		'main' => array(
			'source'  => THEME_URI .'/assets/js/main.js',
			'version' => THEME_VERSION,
			'footer'  => TRUE,
		)
	),

	// Stylesheets to be loaded in the theme
	'styles' => array(
		'bootstrap' => array(
			'source'  => THEME_URI . '/assets/vendor/bootstrap/dist/css/bootstrap.min.css',
			'version' => '4.0.0',
		),

		'fontawesome' => array(
			'source' => THEME_URI . '/assets/vendor/font-awesome/css/font-awesome.min.css',
			'version' => '4.7.0',
		),

		'main' => array(
			'source' => THEME_URI . '/assets/css/main.css',
			'version'=> THEME_VERSION,
		)
	),

	// Specify fonts as 'fontname' => 'font stylesheet URL'
	'fonts' => array(),

	// Theme menus
	// All you need is array( array( array('<location>' => '<menu label>'), ... )
	'menus' => array(
		'main-menu'   => __( 'Main Menu', THEME_DOMAIN ),    	// main nav 
		'mobile-menu' => __( 'Mobile Menu', THEME_DOMAIN ),  	// mobile nav 
		'footer-menu' => __( 'Footer Menu', THEME_DOMAIN ) 		// footer nave
	),

	// Enable Shortcodes found in /library/shortcodes
	'shortcodes' => array('lorem_ipsum'),

);