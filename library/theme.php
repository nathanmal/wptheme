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
	 * Get the theme singleton 
	 * @return [type] [description]
	 */
	public static function instance()
	{
		if( empty(self::$instance) ) self::$instance = new Theme();

		return self::$instance;
	}


	/**
	 * Theme constructor
	 */
	public function __construct()
	{		
		// Check compatibility
		$this->compat();

		// Load theme files
		$this->includes();

		// Load theme actions
		$this->actions();
	}

	/**
	 * Check theme compatibility
	 * @return [type] [description]
	 */
	protected function compat()
	{

	}

	/**
	 * Include classes and functions
	 * @return [type] [description]
	 */
	protected function includes()
	{
		// Load functions
		include_once THEME_LIB . '/inc/strings.php';
		include_once THEME_LIB . '/inc/arrays.php';
		include_once THEME_LIB . '/inc/assets.php';
		include_once THEME_LIB . '/inc/templates.php';
		include_once THEME_LIB . '/inc/content.php';
		include_once THEME_LIB . '/inc/debug.php';

		// Load core classes
		$this->load_class('template');
		$this->load_class('enqueue');
		$this->load_class('option');
		$this->load_class('menu');

		// load admin
		if( is_admin() )
		{
			include_once THEME_LIB . '/inc/admin.php';
			$this->load_class('admin');
		}
	}


	/**
	 * Load a class and attach instance to theme singleton
	 * @param  string $name [description]
	 * @return [type]       [description]
	 */
	protected function load_class( $name = '' )
	{
		$path = THEME_LIB . '/classes/' . $name . '.php';

		include_once $path;

		$class = '\\WPTheme\\' . ucfirst($name);

		$this->{$name} = new $class;
	}



	/**
	 * Load primary actions
	 * @return [type] [description]
	 */
	protected function actions()
	{
		// Hook into WP theme activation
		add_action( 'after_switch_theme', array( $this, 'activate') );

		// Hook into WP theme deactivation
		add_action( 'switch_theme', array( $this, 'deactivate') );

		// Setup the theme options & supports
		add_action( 'after_setup_theme', array( $this, 'init') );
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
    $this->supports();

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
	public function supports()
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