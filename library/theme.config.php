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
			'footer' => TRUE
		),


		'bootstrap' => array(
			'source'       => THEME_URI .'/assets/vendor/bootstrap/dist/js/bootstrap.bundle.js',
			'dependencies' => array('jquery'),
			'version'      => '4.0.0',
			'footer'       => TRUE
		),

		'theme' => array(
			'source'  => THEME_URI .'/assets/js/theme.js',
			'version' => THEME_VERSION,
			'footer'  => TRUE
		)
	),

	// Stylesheets to be loaded in the theme
	'styles' => array(
		'bootstrap' => array(
			'source'  => THEME_URI . '/assets/vendor/bootstrap/dist/css/bootstrap.min.css',
			'version' => '4.0.0',
		),

		'theme' => array(
			'source' => THEME_URI . '/assets/css/theme.css',
			'version'=> THEME_VERSION
		)
	),

	// Theme menus
	'menus' => array(
		'main' => array(

		)
	)
);