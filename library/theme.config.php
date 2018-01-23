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
	'fonts' => array(
		'abril' => 'https://fonts.googleapis.com/css?family=Abril+Fatface',
		'opensans' => 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800',
	),

	// Theme menus
	// All you need is array( array( array('<location>' => '<menu label>'), ... )
	'menus' => array(
		'main-menu'   => __( 'Main Menu', THEME_DOMAIN ),    	// main nav 
		'mobile-menu' => __( 'Mobile Menu', THEME_DOMAIN ),  	// mobile nav 
		'footer-menu' => __( 'Footer Menu', THEME_DOMAIN ) 		// footer nave
	),

	// Theme sidebars
	'sidebars' => array(
		array(
			'id' => 'main',
			'name' => __( 'Main Sidebar', THEME_DOMAIN ),
			'description' => __( 'The main sidebar.', THEME_DOMAIN ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		)
	),

	// Enable custom widgets found in /library/widgets/
	'widgets' => array('intro','links'),

	// Enable Shortcodes found in /library/shortcodes/
	'shortcodes' => array('lorem_ipsum'),

);