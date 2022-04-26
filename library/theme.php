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
	 * Get the theme instance 
	 * @return [type] [description]
	 */
	public static function instance()
	{
		if( empty(self::$instance) ) self::$instance = new Theme();

		return self::$instance;
	}



	/**
	 * Shortcode instances
	 * @var array
	 */
	private $shortcodes = array();



	/**
	 * Theme constructor
	 */
	public function __construct()
	{	
		// Load theme classes
		$this->includes();

		// Hook into WP theme activation
		add_action( 'after_switch_theme', array( $this, 'activate') );

		// Hook into WP theme deactivation
		add_action( 'switch_theme', array( $this, 'deactivate') );

		// Setup the theme options & supports
		add_action( 'after_setup_theme', array( $this, 'init') );

		// load admin if needed
		if( is_admin() )
		{
			$this->admin = new Admin();
		}

	}

	/**
	 * Include classes and functions
	 * @return [type] [description]
	 */
	private function includes()
	{
		include_once THEME_LIB . '/classes/template.php';
		include_once THEME_LIB . '/classes/enqueue.php';
		include_once THEME_LIB . '/classes/option.php';
		include_once THEME_LIB . '/classes/menu.php';
	}

	/**
	 * Returns TRUE if we are using a child theme
	 * @return boolean [description]
	 */
	public function has_child()
	{
		return ! (STYLESHEETPATH === TEMPLATEPATH);
	}


	/**
	 * Run theme setup
	 * @return [type] [description]
	 */
	public function init()
	{
		// Add slug className to body
		add_filter( 'body_class', array( $this, 'body_class' ) );

		// Customizer controls
		add_action( 'customize_register', array( '\WPTheme\Customize', 'init' ), 10, 1 );

    // Add theme support
    $this->add_supports();

    // Register custom menus
		$this->register_menus();

		// Register custom sidebars
		$this->register_sidebars();

		// Register custom shortcodes
		$this->register_shortcodes();

		// Remove unwanted hooks
		$this->cleanup_hooks();
	}


	/**
	 * Add theme supports
	 */
	public function add_supports()
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

		// Woocommerce support
		add_theme_support( 'woocommerce' );

		// Add zoom gallery support
		add_theme_support( 'wc-product-gallery-zoom' );
		
		// Product galleries
		add_theme_support( 'wc-product-gallery-lightbox' );
		
		// Product gallery sliders
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * Register custom menus
	 * @return [type] [description]
	 */
	public function register_menus()
	{
		$menus = apply_filters( 'wpt_register_menus',array(
		  'main'    => __( 'Main Menu',    THEME_DOMAIN ), 
		  'mobile'  => __( 'Mobile Menu',  THEME_DOMAIN ), 
		  'members' => __( 'Members Menu', THEME_DOMAIN ),   
		  'footer'  => __( 'Footer Menu',  THEME_DOMAIN ),
		  'links'   => __( 'Links Menu',   THEME_DOMAIN ),
		  'social'  => __( 'Social Menu',  THEME_DOMAIN )
		));

		foreach($menus as $menu => $description)
		{
			register_nav_menu($menu, __($description, THEME_DOMAIN));
		}
	}

	/**
	 * Register sidebars defined in theme.config.php
	 * @return [type] [description]
	 */
	public function register_sidebars()
	{
		$sidebars = apply_filters( 'wpt_register_sidebars', array(
			array(
	      'id'            => 'main',
	      'name'          => __( 'Primary Sidebar', THEME_DOMAIN ),
	      'description'   => __( 'The primary sidebar.', THEME_DOMAIN ),
	      'before_widget' => '<div id="%1$s" class="widget %2$s">',
	      'after_widget'  => '</div>',
	      'before_title'  => '<h4 class="widgettitle">',
	      'after_title'   => '</h4>'
	    ),

	    array(
	      'id'            => 'footer',
	      'name'          => __( 'Footer Sidebar', THEME_DOMAIN ),
	      'description'   => __( 'The footer sidebar.', THEME_DOMAIN ),
	      'before_widget' => '<div id="%1$s" class="widget %2$s">',
	      'after_widget'  => '</div>',
	      'before_title'  => '<h4 class="widgettitle">',
	      'after_title'   => '</h4>'
	    )
		));

		foreach($sidebars as $sidebar)
		{
			register_sidebar( $sidebar );
		}
	}


	/**
	 * Add shortcodes specified in config
	 */
	public function register_shortcodes()
	{
		$shortcodes = apply_filters( 'wpt_register_shortcodes', array(
			'lipsum'  => '\\WPTheme\\Shortcode\\Lipsum',
			'partial' => '\\WPTheme\\Shortcode\\Partial'
		));

		foreach($shortcodes as $id => $class)
		{
			if( isset($this->shortcodes[$id]) )
			{
				wp_die('Shortcode already loaded: ' . $id);
			}

			if( empty($class) )
			{
				$class = '\\WPTheme\\Shortcode\\' . ucfirst($tag);
			}

			if( ! class_exists($class) )
			{
				wp_die('Could not load shortcode class: ' . esc_html($class) );
			}

			$this->shortcodes[$id] = new $class;
		}
	}


	
	/**
	 * Clean up wordpress head etc
	 * @category optimization
	 * @return [type] [description]
	 */
	public function cleanup_hooks()
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

		// Disable emoji stylesheets
		$this->disable_emojis();
	}

	/**
   * Disable emojis if we don't need them
   * @return [type] [description]
   */
  private function disable_emojis()
  {
    // Remove emoji script
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    // Remove admin emoji sripts
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    // Remove emoji styles
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    // Remove admin emoji styles
    remove_action( 'admin_print_styles', 'print_emoji_styles' );

    // Remove feed emojis
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    // Remove comment emjois
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    // Remove email emojis
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

    // Remove emojis from tinymce
    add_filter( 'tiny_mce_plugins', [$this,'disable_emojis_tinymce'] );
    // Remove emoji prefetching
    add_filter( 'wp_resource_hints', [$this,'disable_emojis_prefetch'], 10, 2 );

  }

  /**
   * Remove emoji plugin from tinymce
   * @param  [type] $plugins [description]
   * @return [type]          [description]
   */
  public function disable_emojis_tinymce( $plugins )
  {
    return is_array($plugins) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
  }

  /**
   * Disable emoji DNS prefetch
   * @param  [type] $urls          [description]
   * @param  [type] $relation_type [description]
   * @return [type]                [description]
   */
  public function disable_emojis_prefetch( $urls, $relation_type ) 
  {
    if ( 'dns-prefetch' == $relation_type ) 
    {
      /** This filter is documented in wp-includes/formatting.php */
      $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

      $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }

    return $urls;
 }


	/**
	 * Echo the page/post's <title></title>
	 * @return [type] [description]
	 */
	public function title()
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
	public function classes( $element = NULL )
	{
		// Get from array
		$classes = (string) wpt_element( Theme::$classes, $element, '' );

		// Remove duplicate classes
		$classes = implode(' ',array_unique(explode(' ', $classes)));

		return $classes;
	}

	/**
	 * Output menu by name
	 * @see 	 https://developer.wordpress.org/reference/functions/wp_nav_menu/ 
	 * @param  string $name   [description]
	 * @param  array  $config Allow function to override default menu array
	 * @return [type]         [description]
	 */
	public function menu( string $name, array $config = array() )
	{

		if( ! has_nav_menu($name) ) 
		{
			echo '[Could not locate menu ' . $name .']';
			return;
		}


		$menu = array(
			'theme_location'  => $name,              
			'container'       => '',                           		
			'container_class' => 'nav-container',  								 
			'menu_class'      => 'nav-wrapper',               					
			// 'fallback_cb'     => array('WPTheme\\Navwalker','fallback'),
    	// 'walker'          => new Navwalker()
		);

		$menu = wp_parse_args($config, $menu);

		wp_nav_menu($menu);

	}

	/**
	 * Show less information on failed login attempt
	 * @category security
	 * @return [type] [description]
	 */
	public function secure_failed_login() 
	{
		return '<strong>ERROR</strong>: Invalid Login!';
	}


	/**
	 * Add page slug to body class
	 * @param [type] $classes [description]
	 */
	public function body_class( $classes ) 
	{
		if( $type = wpt_template_type() )
		{
			$classes[] = 'template-' . $type;
		}
		
		if( $post = get_post() ) 
		{
			$classes[] = 'post-type-' . $post->post_type;

			$classes[] = 'post-slug-' . $post->post_name;

			$classes[] = $post->post_type . '-' . $post->post_name;


		}

		return $classes;
	}	

	

	/**
	 * Load the template using similar WP style heirarchy
	 * 
	 * @return [type] [description]
	 */
	public function render()
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
	public function get_page_slug( $post_id )
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
	public function view( $path, $data = array(), $repeat = 1, $return = FALSE )
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
	public function partial( $path, $data = array(), $repeat = 1 )
	{	
		Theme::view( 'partials/' . $path, $data, $repeat );
	}

	

	/**
	 * Check if view file exists
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	public function view_exists($name)
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
	public function template_exists($name)
	{  
		return Theme::view_exists('templates/'.$name);
	}

	

	/**
	 * Hide admin bar from logged in users
	 * @return [type] [description]
	 */
	public function restrict_admin()
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


	


	public function cache( $key, $value = NULL, $expire = 86400 )
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
	public function debug($msg)
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
	public function error( $message, $context = NULL, $line = NULL )
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
	public function log( $message, $level = 'info' )
	{
		if( is_string($level) && ! empty($level) ) $message = '['.$level.'] ' . $message;

		$message = '[wptheme] ' . $message;

		error_log( $message );
	}

		/**
	 * Called on theme activation
	 * @return [type] [description]
	 */
	public function activate()
	{

	}

	/**
	 * Called on theme deactivation
	 * @return [type] [description]
	 */
	public function deactivate()
	{
		
	}

}

// Global theme getter
function theme() { return \WPTheme\Theme::instance(); }