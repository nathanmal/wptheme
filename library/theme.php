<?php

namespace WPTheme;

use WPTheme\Navwalker;


if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Core theme object
 */
final class Theme
{
	/**
	 * Theme singleton
	 * @var null
	 */
	private static $instance = NULL;

	/**
	 * Theme init
	 * @var boolean
	 */
	private static $initialized = FALSE;

	/**
	 * Theme config array
	 * @var null
	 */
	private static $config = array();

	/**
	 * Template view file being used
	 * @var string
	 */
	private static $template = '';

	/**
	 * Holds paths
	 * @var array
	 */
	private static $paths = array();

	/**
	 * Auto render header
	 * @var boolean
	 */
	private static $header = TRUE;

	/**
	 * Auto render footer
	 * @var boolean
	 */
	private static $footer = TRUE;

	/**
	 * Hold element class names
	 * @var array
	 */
	private static $classes = array(
		'header' => 'header header-fixed',
		'page'   => 'container no-padding'
	);

	/**
	 * Get the theme instance 
	 * @return [type] [description]
	 */
	public static function instance()
	{
		if( empty(self::$instance) ) self::$instance = new Theme();
			
		return self::$instance;
	}
	

	/**
	 * Initialization
	 * @return [type] [description]
	 */
	public static function init()
	{
		// Only allow init once
		if( self::$initialized ) return;

		// Register Post Types
		Theme::register_post_types();

		// Register nav menus
		Theme::register_menus();

		// Register sidebars
		Theme::register_sidebars();

		// Register widgets
		Theme::register_widgets();

		// Register theme libraries
		Theme::register_libraries();

		// Register actions & filters
		Theme::register_actions();

		// Load custom shortcodes
		Theme::register_shortcodes();

		// Declare support 
		Theme::declare_support();

		// Run security routines
		Theme::security();

		// load theme custom functions
		require_once( THEME_DIR . '/config/functions.php' );

		// load admin if needed
		if( is_admin() ) Admin::init();

  	// Mark initialized
		self::$initialized = TRUE;
	}

	/**
	 * Get theme config
	 * @param  [type] $item    [description]
	 * @param  [type] $default [description]
	 * @return [type]          [description]
	 */
	public static function config( $item = NULL, $default = NULL )
	{
		return empty($item) ? Theme::$config : element(Theme::$config, $item, $default);
	}


	/**
	 * Register custom post types
	 * @return [type] [description]
	 */
	public static function register_post_types(){}


	/**
	 * Register menus defined in theme.config.php
	 * @return [type] [description]
	 */
	public static function register_menus()
	{
		$menus =  array(
		  'main-menu'   => __( 'Main Menu',   THEME_DOMAIN ),    
		  'footer-menu' => __( 'Footer Menu', THEME_DOMAIN ),
		);

		foreach($menus as $menu => $label) register_nav_menu($menu, __($label, THEME_DOMAIN) );
	}

	/**
	 * Register sidebars defined in theme.config.php
	 * @return [type] [description]
	 */
	public static function register_sidebars()
	{
		$sidebars = array(
			'main' => array(
	      'id'            => 'main',
	      'name'          => __( 'Main Sidebar', THEME_DOMAIN ),
	      'description'   => __( 'The main sidebar.', THEME_DOMAIN ),
	      'before_widget' => '<div id="%1$s" class="widget %2$s">',
	      'after_widget'  => '</div>',
	      'before_title'  => '<h4 class="widgettitle">',
	      'after_title'   => '</h4>'
	    )
    );

		foreach($sidebars as $sidebar)
		{
			register_sidebar($sidebar);
		}
	}


	/**
	 * Register widgets defined in theme.config.php
	 * @return [type] [description]
	 */
	public static function register_widgets()
	{
		// load widget files
		$files  = glob(THEME_LIB.'/widgets/*.php');

		if( ! empty($files) )
		{
			foreach($files as $file) 
			{
				include $file;

				$name  = pathinfo($file, PATHINFO_FILENAME);
				$class = ucfirst($name) . '_Widget';

				if( class_exists($class, FALSE) )
				{
					register_widget($class);
				}
			}
		}
	}

	/**
	 * Register front end libraries
	 * @return [type] [description]
	 */
	public static function register_libraries()
	{
		if( ! is_admin() ) wp_deregister_script('jquery');
		
		Enqueue::register_libraries();
	}


	/**
	 * Register actions & filters
	 * @return [type] [description]
	 */
	public static function register_actions()
	{
		// Hide descriptive login errors
		add_filter( 'login_errors', 'WPTheme\\Theme::secure_failed_login' );

		// remove WP version from css
		add_filter( 'style_loader_src', array('WPTheme\\Enqueue', 'remove_asset_version'), 9999 );

		// remove Wp version from scripts
		add_filter( 'script_loader_src', array('WPTheme\\Enqueue', 'remove_asset_version'), 9999 );

		// Apply attributes to style/script tags
		add_filter( 'script_loader_tag', array('WPTheme\\Enqueue', 'script_attributes'), 10, 3 );

		// Add slug className to body
		add_filter( 'body_class', array( __CLASS__, 'body_class' ) );

		// Manage theme template directory
		add_filter( 'theme_page_templates', array(__CLASS__, 'page_templates'), 10, 4);

		// Register Widgets
		add_action( 'widgets_init', 'WPTheme\\Theme::register_widgets');

		// Enqueue scripts on front end
		add_action( 'wp_enqueue_scripts', '\WPTheme\\Theme::enqueue', 10, 1);

		/*
		$temps = ["404_template","search_template","frontpage_template","home_template","privacypolicy_template","taxonomy_template","attachment_template","single_template","page_template","singular_template","category_template","tag_template","author_template","date_template","archive_template","index_template"];
	
		foreach( $temps as $t )
		{
			add_filter($t, [__CLASS__, 'find_template'], 10, 3);
		}
		*/

		//add_filter( 'frontpage_template', [__CLASS__, 'frontpage_template'], 10, 3);
		//add_filter( 'page_template', [__CLASS__, 'page_template'], 10, 3);
	}

	public static function find_template( $template, $type, $templates )
	{
		switch($type)
		{
			case 'frontpage':

				return locate_template('views/front.php');
				break;

			case 'page':

				return locate_template(['views/page.php']);
				break;

			case '404':

				return locate_template('views/404.php');
				break;

			default:
				break;
		}

		return $template;

	}

	public static function frontpage_template( $template, $type, $templates )
	{
		pre($template);
		pre($type);
		pre($templates);
	}

	public static function page_template( $template, $type, $templates )
	{
		pre($template);
		pre($type);
		pre($templates);
	}

	/**
	 * Add shortcodes specified in config
	 */
	public static function register_shortcodes()
	{
		$files  = glob(THEME_LIB.'/shortcodes/*.php');

		if( ! empty($files) )
		{
			foreach($files as $file) include $file;
		}
	}

	/**
	 * Declare supports for this theme
	 * @return [type] [description]
	 */
	public static function declare_support()
	{		
		// Declare thumbnail support
		add_theme_support( 'post-thumbnails' );

		// default thumb size
		set_post_thumbnail_size( 125, 125, TRUE );

		// Declare menu support
		add_theme_support( 'menus' );

		// Declare HTML5 support
		add_theme_support( 'html5', array('comment-list','search-form','comment-form') );

		// Add RSS Support
		add_theme_support( 'automatic-feed-links' );

	}



	/**
	 * Default security measures
	 * @category optimization
	 * @return [type] [description]
	 */
	public static function security()
	{

		// Remove generated by tag
		add_filter( 'the_generator', '__return_empty_string' );


		// Edit URI link
		remove_action( 'wp_head', 'rsd_link' );
		// windows live writer
		remove_action( 'wp_head', 'wlwmanifest_link' );
		// previous link
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
		// start link
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		// links for adjacent posts
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		// WP version
		remove_action( 'wp_head', 'wp_generator' );
		// Remove index link
		remove_action( 'wp_head', 'index_rel_link' );
		// Remove feed links
		remove_action( 'wp_head', 'feed_links', 2 );
		// Remove extra feed links
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		// Remove shortlink
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
		// Remove rest head link
		remove_action( 'wp_head',  'rest_output_link_wp_head');
		// Remove oembed
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links');
		// Remove rest output header
		remove_action( 'template_redirect', 'rest_output_link_header', 11 );

		// Disable emojis
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		// Filter out emojis
		add_filter( 'tiny_mce_plugins', array(__CLASS__, 'disable_emojis_tinymce') );
		add_filter( 'wp_resource_hints', array(__CLASS__,'disable_emojis_remove_dns_prefetch'), 10, 2 );

	}











	


	/**
	 * Resolve path to allow /theme files to override /library files
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	public static function find($path)
	{
		// Return if cached
		if( isset(self::$paths[$path]) ) return self::$paths[$path];
		
		foreach( array('/','/library/') as $dir )
		{
			$file = THEME_DIR . $dir . ltrim($path,'/');
			// Found
			if( is_file( $file ) ) return $file;
		}

		return FALSE;

	}

	/**
	 * Get theme URI path
	 * @param  string $path path to add to the URI
	 * @return [type]       [description]
	 */
	public static function uri( $path = '' )
	{
		return trailingslashit(THEME_URI) . ( ! empty($path) ? ltrim($path, '/') : '' );
	}

	/**
	 * Get theme directory path
	 * @param  string $path [description]
	 * @return [type]       [description]
	 */
	public static function dir( $path = '' )
	{
		return trailingslashit(THEME_DIR) . ( ! empty($path) ? ltrim($path, '/') : '' );
	}

	/**
	 * Get the URL of an asset
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	public static function asset( $path )
	{
		// No bueno
		if( empty($path) ) return FALSE;

		$path = strpos($path, 'assets/') === 0 ? $path : 'assets/' . ltrim($path, '/');

		// Return if cached
		if( isset(self::$paths[$path]) ) return self::$paths[$path];

		// Check if file exists
		if( is_file( THEME_DIR . '/' . $path ) ) 
		{
			// Cache the path
			self::$paths[$path] = THEME_URI . '/' . $path;

			return self::$paths[$path];
		}

		return FALSE;
	}

	/**
	 * Get src uri for an asset
	 * can be external http or theme asset url
	 * @param  [type] $uri [description]
	 * @return [type]      [description]
	 */
	public static function src( $uri )
	{
		return 0 === strpos($uri, 'http') ? $uri : Theme::asset($uri);
	}


	/**
	 * Echo the page/post's <title></title>
	 * @return [type] [description]
	 */
	public static function title()
	{
		$name = get_bloginfo('name');
		$desc = get_bloginfo('description');

		echo '<title>' . ( is_front_page() ? $name . ' : ' . $desc : wp_title('', false) ) . '</title>';
	}


	/**
	 * Get class names for an element
	 * @param  [type] $element [description]
	 * @return [type]          [description]
	 */
	public static function classes( $element = NULL )
	{
		// Get from array
		$classes = (string) element( Theme::$classes, $element, '' );

		// Remove duplicate classes
		$classes = implode(' ',array_unique(explode(' ', $classes)));

		return $classes;
	}

	/**
	 * Add class name to an element
	 * @param [type] $element [description]
	 * @param [type] $classes [description]
	 */
	public static function addClass( $element, $classes )
	{
		// classes can be a string or array of strings
		$classes = is_array($classes) ? implode(' ', $classes ) : $classes;

		if( ! isset(Theme::$classes[$element]) ) Theme::$classes[$element] = '';

		Theme::$classes[$element] .= (string) $classes;
	}


	/**
	 * Output menu by name
	 * @see 	 https://developer.wordpress.org/reference/functions/wp_nav_menu/ 
	 * @param  string $name   [description]
	 * @param  array  $config Allow function to override default menu array
	 * @return [type]         [description]
	 */
	public static function menu( $name='', $config = array() )
	{
		$label = ucfirst($name) . ' Menu';
		
		$location = $name . '-menu';

		if( ! has_nav_menu($location) ) {
			echo "[Could not locate menu $location]";
			return;
		};

		$default = array(
			'menu'            => __( $label, THEME_DOMAIN ), 
			'theme_location'  => $location,              
			'container'       => '',                           		
			'container_class' => '',  								 
			'menu_class'      => '',               					
			'depth'           => 0,
			'fallback_cb'     => array('WPTheme\\Navwalker','fallback'),
    	'walker'          => new Navwalker()
		);

		wp_nav_menu(wp_parse_args($config,$default));

	}

	/**
	 * Render sidebar
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	public static function sidebar( $name = NULL )
	{
		get_sidebar( $name );
	}



	public static function background()
	{
		return '';
	}

	/**
	 * Render post/page content
	 * @param  string $view          [description]
	 * @param  string $post_template [description]
	 * @return [type]                [description]
	 */
	public static function content( $str = NULL )
	{
		if( is_string($str) )
		{
			return apply_filters( 'the_content', $str );
		}

		// No posts found or loaded
		if( ! have_posts() ) return 'Nothing found';

		// Loop
		while ( have_posts() ) : the_post();

			the_content();

		endwhile;
		
	}



	public static function option( $name )
	{

	}

	public static function update( $name, $value )
	{

	}



	//////////////////////////////////////////////////////////////////////////////////////////
	/// HOOK METHODS
	//////////////////////////////////////////////////////////////////////////////////////////

	

	/**
	 * Filter function used to remove the tinymce emoji plugin.
	 * 
	 * @param array $plugins 
	 * @return array Difference betwen the two arrays
	 */
	public static function disable_emojis_tinymce( $plugins ) 
	{
	 return is_array($plugins) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
	}

	/**
	 * Remove emoji CDN hostname from DNS prefetching hints.
	 *
	 * @param array $urls URLs to print for resource hints.
	 * @param string $relation_type The relation type the URLs are printed for.
	 * @return array Difference betwen the two arrays.
	 */
	public static function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) 
	{
	 if ( 'dns-prefetch' == $relation_type ) {
		 /** This filter is documented in wp-includes/formatting.php */
		 $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
		 $urls = array_diff( $urls, array( $emoji_svg_url ) );
	 }

	 return $urls;
	}

	



	/**
	 * Show less information on failed login attempt
	 * @category security
	 * @return [type] [description]
	 */
	public static function secure_failed_login() 
	{
		return '<strong>ERROR</strong>: Invalid Login!';
	}


	/**
	 * Add page slug to body class
	 * @param [type] $classes [description]
	 */
	public static function body_class( $classes ) 
	{
		global $post;

		$classes[] = str_replace('/', '-', self::template());

		if ( isset( $post ) ) 
		{
			$classes[] = $post->post_type . '-' . $post->post_name;
		}

		return $classes;
	}	


	/**
	 * Enqueue theme scripts and styles
	 * @return [type] [description]
	 */
	public static function enqueue()
	{
		// Don't enqueue in admin area
		if( is_admin() ) return;

		// Don't enqueue on login or register screen
		if( $GLOBALS['pagenow'] === 'wp-login.php' ) return;

		Enqueue::library('jquery');
		Enqueue::library('bootstrap');
		Enqueue::library('fontawesome');
		Enqueue::library('fontawesome-solid');
		Enqueue::library('fontawesome-brands');
		Enqueue::library('wptheme');
			
	}



	

	/**
	 * Load theme templates
	 * 
	 * Wordpress has a hard time with this because it's default depth search is
	 * only 1 directory, so we gotta do it manually here
	 *
	 * Hook: theme_page_templates
	 * @see https://developer.wordpress.org/reference/hooks/theme_page_templates/
	 * 
	 * @param  [type] $templates [description]
	 * @param  [type] $theme     [description]
	 * @param  [type] $post      [description]
	 * @param  [type] $post_type [description]
	 * @return [type]            [description]
	 */
	public static function page_templates( $templates, $theme, $post, $post_type )
	{
		$directory 	= THEME_DIR . '/views/templates/';

		$files 			= scandir( $directory );

		foreach($files as $file)
		{	
			$ext  = pathinfo($file, PATHINFO_EXTENSION);

			$path = $directory . $file;

			if( strpos($file, '.') === 0 OR $ext !== 'php' OR ! is_file($path) ) continue;

			if ( ! preg_match( '|Template Name:(.*)$|mi', file_get_contents( $path ), $header ) ) 
			{
				continue;
			}

			$template = 'views/templates/' . $file;

			$templates[$template] = _cleanup_header_comment( $header[1] );

		}

		/* Remove this file, since it cataches the preg above */
	  if( isset($templates['library/theme.php']) ) unset($templates['library/theme.php']);

		return $templates;
	}

	/**
	 * Load a page template
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	public static function template()
	{
		return self::$template;
	}

	/**
	 * Output the header
	 * @return [type] [description]
	 */
	public static function header()
	{
		Theme::view('header');
		// Don't allow this to be called again
		Theme::$header = FALSE;
	}

	/**
	 * Output the footer
	 * @return [type] [description]
	 */
	public static function footer()
	{
		Theme::view('footer');
		// Don't allow this to be called again
		Theme::$footer = FALSE;
	}

	/**
	 * Load the template using similar WP style heirarchy
	 * 
	 * @return [type] [description]
	 */
	public static function render()
	{
		$id 		= get_the_ID();
		$type   = get_post_type($id);
		$arch   = ! empty($type) ? 'archive-' . $type : FALSE;
		$sing   = ! empty($type) ? 'single-' . $type : FALSE;

		// Default
		$template = 'index';

		// Check for missing
		if( is_404() ) {
			$template = '404';
		// Front page
		} else if( is_front_page() && Theme::view_exists('front') ) {
			$template = 'front';
		// Home page
		} else if( is_home() && Theme::view_exists('home') ) {
			$template = 'home';
		// Search Page
		} else if( is_search() && Theme::view_exists('search') ) {
			$template = 'search';
		// Custom pages by slug or post_type
		} else if( is_page() ) {

			// Get the page uri including subdirectories
			$slug = get_page_uri($id);

			if( $slug && Theme::view_exists('pages/'.$slug) ){
				$template = 'pages/'.$slug;
			} 
			else if( ! empty($type) && Theme::view_exists('pages/'.$type) ) {
				$template = 'pages/'.$type;
			}
			else if( Theme::view_exists('page') ) {
				$template = 'page';
			}
			
		// Single Posts	by type or template				
		} else if( is_single() ) {
			if( ! empty($type) && Theme::view_exists('single/'.$type) ) {
				$template = 'single/'.$type;
			} else if( Theme::view_exists('single') ) {
				$template = 'single';
			}

		// Archives
		} else if( is_archive() ) {

			if( ! empty($type) && is_post_type_archive($type) 
				&& Theme::view_exists('archive/'.$type) ){
				$template = 'archive/'.$type; 
			} else if ( Theme::view_exists('archive') ){
				$template = 'archive';
			}
		}


		// Set the template
		self::$template = $template;



		// Render page content before header
		$body = self::view($template, array(), 1, TRUE);
		
		// Render to browser
		get_header();
		echo $body;
		get_footer();

	}

	/**
	 * Get slug of a page
	 * @param  int $post_id ID of post
	 * @return string|false FALSE if post is not a page
	 */
	public static function get_page_slug($post_id)
	{
		$post = get_post($post_id);
		return $post->post_type === 'page' ? $post->post_name : FALSE;
	}



	/**
	 * Include a view from the views directory
	 * @param  string  $path   path to the view 
	 * @param  array   $data   associative array of data to supply to view
	 * @param  integer $repeat multiplier, how many times to include the view, to create loops
	 * @return [type]          [description]
	 */
	public static function view( $path, $data = array(), $repeat = 1, $return = FALSE )
	{
		// Append extension if needed
		if( substr($path, -4) != '.php' ) $path .= '.php';
		
		// Set absolute path
		$file = self::find( 'views/' . $path );

		// Warn if missing
		if( empty($file) OR ! is_file($file) ) 
		{
			wp_die('Could not locate view:<br/><strong>' . $path . '</strong>');
		}

		// If non-empty array, extract variables for the view
		if( ! empty($data) && is_array($data) ) 
		{
			foreach( $data as $key => $val )
			{
				// Convert unnamed (indexed) items so that its value is true
				if( is_int($key) ) {
					$data[$val] = TRUE;
					unset($data[$key]);
				}
			}
			// Extract but don't overwrite vars
			extract($data, EXTR_SKIP);
		}

		if( $return ) {
			ob_start();
		}

		// Include with repeat
		for( $i = 1; $i <= $repeat; $i++ ){
			$loop_total = $repeat;
			$loop_count = $i;
			include($file);
		}

		if( $return )
		{
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}

	}

	/**
	 * Include a partial
	 * Just shorthand for the view function
	 * @param  [type]  $path   [description]
	 * @param  array   $data   [description]
	 * @param  integer $repeat [description]
	 * @return [type]          [description]
	 */
	public static function partial( $path, $data = array(), $repeat = 1 )
	{	
		Theme::view( 'partials/' . $path, $data, $repeat );
	}

	

	/**
	 * Check if view file exists
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	public static function view_exists($name)
	{	
		// prep path
		$file = 'views/'.$name.'.php';
		// find it
		return FALSE !== Theme::find($file);
	}

	/**
	 * Checks if a template exists
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	public static function template_exists($name)
	{  
		return Theme::view_exists('templates/'.$name);
	}

	

	/**
	 * Hide admin bar from logged in users
	 * @return [type] [description]
	 */
	public static function restrict_admin()
	{	
		if( ! current_user_can('administrator') )
		{
			 if( is_admin() ) 
			 { 
			 		if( defined('DOING_AJAX') && DOING_AJAX ) return;

			 		wp_redirect(site_url('home'));
			 }
			 else 
			 {
			 	 show_admin_bar(false);
			 }
		}
	}


	/**
	 * Display enqueue files
	 * @category utility
	 * @return [type] [description]
	 */
	public static function debug_enqueue() 
	{
	    global $wp_scripts, $wp_styles;
	   	
	   	echo '<h3>Scripts</h3>';
	    foreach( $wp_scripts->queue as $script )
	    {	
	    	echo $script . '<br/>';
	    }

	    echo '<h3>Styles</h3>';

	    foreach( $wp_styles->queue as $style )
	    {
	    	echo $style . '<br/>';
	    }

	}


	public static function cache( $key, $value = NULL, $expire = 86400 )
	{
		if( empty($key) ) return FALSE;

		$key = 'wpt-' . $key;

		if( is_null($value) )
		{
			return get_transient( $key );
		}

		set_transient( $key, $value, intval($expire) );
	}

	/**
	 * Debugging
	 * @param  [type] $msg [description]
	 * @return [type]      [description]
	 */
	public static function debug($msg)
	{
		if( WP_DEBUG ) {
			if( is_array($msg) or is_object($msg) ) pre($msg);
			if( is_string($msg) ) echo $msg;
		}
	}

	/**
	 * Log an error
	 * @param  [type] $message [description]
	 * @return [type]          [description]
	 */
	public static function error( $message, $context = NULL, $line = NULL )
	{
		if( ! empty($context) )
		{	
			$class = is_object($context) ? get_class($context) : strval($context);
			$line  = ! empty($line) && is_int($line) ? ' line ' . $line : '';

			$message = $class . $line . ' ' . $message;
		}

		Theme::log($message, 'error');
	}

	/**
	 * Log a message
	 * @param  [type] $message [description]
	 * @param  string $level   [description]
	 * @return [type]          [description]
	 */
	public static function log( $message, $level = 'info' )
	{
		if( is_string($level) && ! empty($level) ) $message = '['.$level.'] ' . $message;

		$message = '[wptheme] ' . $message;

		error_log( $message );
	}

		/**
	 * Called on theme activation
	 * @return [type] [description]
	 */
	public static function activate()
	{

	}

	/**
	 * Called on theme deactivation
	 * @return [type] [description]
	 */
	public static function deactivate()
	{
		
	}

}

// Global theme getter
function theme() { return \WPTheme\Theme::instance(); }