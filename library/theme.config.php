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
		// Main Theme File
		'theme' => array(
			'source'  => 'dist/theme.js',
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
		// Bootstrap 4 CSS
		'bootstrap' => array(
			'source'  => 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css',
			'version' => '4.1.3',
		),
		// Font Awesome 5
		'fontawesome' => array(
			'source' => 'dist/fontawesome.css',
      'version' => '5.0.9',
		),
		// Main theme stylesheet
		'theme' => array(
			'source' => 'dist/theme.css',
			'version'=> time(),
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
	'widgets' => array(),

	/**
	 * Enable shortcodes
	 */
	'shortcodes' => array(),

	/**
	 * Google analytics account id UA-XXXXXX-X
	 */
	'ga' => '',

);