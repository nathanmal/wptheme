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
	 * 	'myscript' => array(
	 * 		'source' => absolute/url/to/source.js,
	 * 		'dependencies' => array('of','dependencies'),
	 * 		'version' => '0.2.1',
	 * 		'footer' => TRUE/FALSE whether to load in footer of page
	 * 	)
	 * 	
	 */
	'scripts' => array(
		// This replaces built in WP jQuery with 3.2.1 and should always be first
		'jquery' => array(
			'source' => THEME_URI . '/library/assets/vendor/jquery/dist/jquery.min.js',
			'version' => '3.2.1',
			'footer' => TRUE,
		),

		'bootstrap' => array(
			'source'       => THEME_URI .'/library/assets/vendor/bootstrap/dist/js/bootstrap.bundle.js',
			'dependencies' => array('jquery'),
			'version'      => '4.0.0',
			'footer'       => TRUE,
		),

		'main' => array(
			'source'  => THEME_URI .'/theme/assets/js/main.js',
			'version' => THEME_VERSION,
			'footer'  => TRUE,
		)
	),

	/**
	 * CSS StyleSheets to be pre-loaded into the theme
	 *
	 * Like scripts, stylesheets are specified by arrays and supply the arguments used
	 * for wp_enqueue_style
	 *
	 * example:
	 *
	 * 	'bootstrap' => array(
	 *		'source'  => THEME_URI . '/assets/vendor/bootstrap/dist/css/bootstrap.min.css',
	 *		'dependencies' => array('jquery'),
	 *		'version' => '4.0.0',
	 *		'media' => 'screen'
	 *	)
	 *
	 */
	'styles' => array(
		'bootstrap' => array(
			'source'  => THEME_URI . '/library/assets/vendor/bootstrap/dist/css/bootstrap.min.css',
			'version' => '4.0.0',
		),

		'fontawesome' => array(
			'source' => THEME_URI . '/library/assets/vendor/font-awesome/css/font-awesome.min.css',
			'version' => '4.7.0',
		),

		'main' => array(
			'source' => THEME_URI . '/theme/assets/css/theme.css',
			'version'=> THEME_VERSION,
		)
	),

	/**
	 * Theme font files
	 *
	 * Specify the font names and absolute URLs to the file stylesheets
	 *
	 * example:
	 *
	 *  'fonts' => array(
	 *		'abril' => 'https://fonts.googleapis.com/css?family=Abril+Fatface',
	 *		'opensans' => 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800',
	 *	),
	 * 
	 */
	'fonts' => array(),

	/**
	 * Theme menus. Add custom menus here. Can add more via /theme/theme.config.php
	 *
	 * defaults:
	 *
	 *	'main-menu'   => __( 'Main Menu', THEME_DOMAIN ),    	// main nav 
	 *	'mobile-menu' => __( 'Mobile Menu', THEME_DOMAIN ),  	// mobile nav 
	 *	'footer-menu' => __( 'Footer Menu', THEME_DOMAIN ) 		// footer nave
	 *
	 */
	'menus' => array(
		'main-menu'   => __( 'Main Menu', THEME_DOMAIN ),    	// main nav 
		'mobile-menu' => __( 'Mobile Menu', THEME_DOMAIN ),  	// mobile nav 
		'footer-menu' => __( 'Footer Menu', THEME_DOMAIN ) 		// footer nave
	),

	
	/**
	 * Theme sidebars. Add custom sidebars here
	 *
	 * default:
	 *
	 * 	array(
	 *		'id' => 'main',
	 *		'name' => __( 'Main Sidebar', THEME_DOMAIN ),
	 *		'description' => __( 'The main sidebar.', THEME_DOMAIN ),
	 *		'before_widget' => '<div id="%1$s" class="widget %2$s">',
	 *		'after_widget' => '</div>',
	 *		'before_title' => '<h4 class="widgettitle">',
	 *		'after_title' => '</h4>',
	 *	)
	 */
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

	/**
	 * Enable Widgets
	 */
	'widgets' => array('intro','links'),

	/**
	 * Enable shortcodes
	 */
	'shortcodes' => array('lorem_ipsum'),

	/**
	 * Google analytics account id UA-XXXXXX-X
	 */
	'ga' => '',

);