<?php
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
	private static $config = NULL;

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
		if( empty(self::$instance) ){
			self::$instance = new Theme();
		}

		return self::$instance;
	}

	/**
	 * PSR-4 Plugin autoloader
	 * Used with spl_autoload_register
	 * @see    http://php.net/manual/en/function.spl-autoload-register.php
	 * @param  string $class Class name
	 */
	public static function autoload($class)
	{	
		$base   = THEME_DIR . '/library/classes/';

		$file = strtolower($class);

		$path =  $base . str_replace('\\','/',$file) . '.php';

		if( is_file($path) ) 
		{	
			require $path;
		}

	}

	/**
	 * Initialization
	 * @return [type] [description]
	 */
	public static function init()
	{
		// Only allow init once
		if( self::$initialized ) return;

		// Load config 
		self::$config = include(THEME_DIR . '/config/theme.config.php');
		
		// Add filters
		add_filter( 'the_generator', 'Theme::remove_generator' );
		// Hide descriptive login errors
		add_filter( 'login_errors', 'Theme::secure_failed_login' );
		// remove WP version from css
		add_filter( 'style_loader_src', 'Theme::remove_asset_version', 9999 );
		// remove Wp version from scripts
		add_filter( 'script_loader_src', 'Theme::remove_asset_version', 9999 );
		// Add slug className to body
		add_filter( 'body_class', 'Theme::add_body_class' );
		// Manage theme template directory
		add_filter( 'theme_page_templates', 'Theme::page_templates', 10, 4);
		// Register Widgets
		add_action( 'widgets_init', 'Theme::register_widgets');
		// Register Theme template directory
		add_filter( 'theme_page_templates', 'Theme::page_templates', 10, 4);

		// Enqueue Scripts and Styles
		Theme::enqueue();
		// Custom Post Types
		Theme::post_types();
		// Register nav menus
		Theme::register_menus();
		// Register sidebars
		Theme::register_sidebars();
		// Declare support 
		Theme::declare_support();
		// Clean up wp_head();
		Theme::cleanup_head();
		// Custom shortcodes
		Theme::add_shortcodes();
		// Hide admin bar from non-admins and redirect them to homepage
		Theme::restrict_admin();

  	// Mark initialized
		Theme::$initialized = TRUE;
	}

	
	//////////////////////////////////////////////////////////////////////////////////////////
	/// UTILITY METHODS
	//////////////////////////////////////////////////////////////////////////////////////////


	/**
	 * Get theme config item
	 * @param  [type] $item [description]
	 * @return [type]       [description]
	 */
	public static function config($item=NULL)
	{
		if( empty($item) ) return self::$config;

		return isset(self::$config[$item]) ? self::$config[$item] : NULL;

	}


	/**
	 * Get theme option, but allow for post meta to override
	 * @param  [type]  $name    [description]
	 * @param  boolean $default [description]
	 * @return [type]           [description]
	 */
	public static function option( $name, $default = NULL )
	{
		$option = 'wptheme_' . $name;

		$value = get_option( $option, $default );

		if( ( is_null($value) OR $value === $default ) && $post = get_post() )
		{
			$meta = get_post_meta( $post->ID, $option, TRUE );

			return ( is_null($meta) OR $meta === $default ) ? $default : $meta;
		}

		return $value;
	}


	/**
	 * Get theme mod
	 * @param  [type] $name    [description]
	 * @param  [type] $default [description]
	 * @return [type]          [description]
	 */
	public static function mod( $name, $default = NULL )
	{
		$name = 'wptheme_' . $name;

		$value = get_theme_mod( $name, $default );

		if( ( is_null($value) OR $value === $default ) && $post = get_post() )
		{
			$meta = get_post_meta( $post->ID, $option, TRUE );

			return ( is_null($meta) OR $meta === $default ) ? $default : $meta;
		}

	}

	/**
	 * Set theme option
	 * @param [type]  $name     [description]
	 * @param [type]  $value    [description]
	 * @param boolean $autoload [description]
	 */
	public static function set_option( $name, $value, $autoload = TRUE )
	{
		$option = 'wptheme_' . $name;

		return update_option( $option, $value, $autoload );
	}


	/**
	 * Resolve path to allow /theme files to override /library files
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	public static function path($path)
	{
		// Return if cached
		if( isset(self::$paths[$path]) ) return self::$paths[$path];
		
		$theme = THEME_DIR . '/'. ltrim($path,'/');
		$core  = THEME_DIR . '/library/' . ltrim($path,'/');

		// Check theme directory first
		if( is_file( $theme ) )
		{
			self::$paths[$path] = $theme;
			return $theme;
		}

		// Check library
		if( is_file( $core ) )
		{
			self::$paths[$path] = $core;
			return $core;
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
		return empty($path) ? THEME_URI : THEME_URI . '/' . ltrim($path, '/');
	}

	/**
	 * Get theme directory path
	 * @param  string $path [description]
	 * @return [type]       [description]
	 */
	public static function dir( $path = '' )
	{
		return empty($path) ? THEME_DIR : THEME_DIR . '/' . ltrim($path, '/');
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















	//////////////////////////////////////////////////////////////////////////////////////////
	/// RENDER METHODS
	//////////////////////////////////////////////////////////////////////////////////////////




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
	 * Echo out the head
	 * @return [type] [description]
	 */
	public static function head()
	{
		wp_head();
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

		if( ! class_exists('Navwalker') ) {
			include THEME_DIR . '/library/classes/navwalker.php';
		}

		$default = array(
			'menu'            => __( $label, THEME_DOMAIN ), 
			'theme_location'  => $location,              
			'container'       => '',                           		
			'container_class' => '',  								 
			'menu_class'      => '',               					
			'depth'           => 0,
			'fallback_cb'     => 'Navwalker::fallback',
    		'walker'        => new Navwalker()                             		
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


	/**
	 * Render post/page content
	 * @param  string $view          [description]
	 * @param  string $post_template [description]
	 * @return [type]                [description]
	 */
	public static function content()
	{
		// No posts found or loaded
		if( ! have_posts() ) return Theme::partial('missing');

		// Loop
		while ( have_posts() ) : the_post();

			// Check post format
			$format = get_post_format();

			// Add post format 
			if( $format ) Theme::addClass('post', 'post-format post-format-' . $format );

			// post wrapper
			echo '<div class="post '. Theme::classes('post').'">';

			// Include format view if used
			if( $format ) 
			{
				Theme::view( 'formats/' . $format );
			}
			else
			{
				Theme::view( 'formats/post' ); 
			}
			
			// close wrapper
			echo '</div>';

		endwhile;

		
	}

	/**
	 * Render a page section
	 * @param  [type] $id      [description]
	 * @param  [type] $content [description]
	 * @param  array  $config  [description]
	 * @return [type]          [description]
	 */
	public static function section( $id, $content, $config = array() )
	{
		$class = element( $config, 'class', '' );

		$container = array_contains( $config, 'wide' ) ? 'container-fluid' : 'container';

		echo '<section id="' . $id . '" class="'.classes($class).'">';

		echo '<div class="'.$container.'">';

		echo $content;

		echo '</div>';

		echo '</section>';
	}



	//////////////////////////////////////////////////////////////////////////////////////////
	/// HOOK METHODS
	//////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Clean up head tags generated by WP by default
	 * @category optimization
	 * @return [type] [description]
	 */
	public static function cleanup_head()
	{
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


	}

	/**
	 * Declare supports for this theme
	 * @return [type] [description]
	 */
	public static function declare_support()
	{
		// load_theme_textdomain( 'startr',  get_template_directory() . '/library/lang' );
		
		// wp thumbnails (sizes handled in functions.php)
		add_theme_support( 'post-thumbnails' );

		// default thumb size
		set_post_thumbnail_size(125, 125, TRUE);

		// wp menus
		add_theme_support( 'menus' );

		// Enable support for HTML5 markup.
		$html5 = array(
			'comment-list',
			'search-form',
			'comment-form'
		);
		
		add_theme_support( 'html5', $html5 );

		// adding post format support
		add_theme_support( 'post-formats',
			array(
				'aside',             // title less blurb
				'gallery',           // gallery of images
				'link',              // quick link to other site
				'image',             // an image
				'quote',             // a quick quote
				'status',            // a Facebook like status update
				'video',             // video
				'audio',             // audio
				'chat'               // chat transcript
			)
		);

		// Add RSS Support
		add_theme_support('automatic-feed-links');

	}


	/**
	 * Strips version attribute from asset URLs
	 * @category optimization
	 * @param  string $src URL to check
	 * @return [type]      [description]
	 */
	public static function remove_asset_version( $src )
	{
		return strpos( $src, 'ver=' ) ? remove_query_arg( 'ver', $src ) : $src;
	}


	/**
	 * Remove WP generator tag from head
	 * @category security
	 * @return [type] [description]
	 */
	public static function remove_generator()
	{
		return '';
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
	public static function add_body_class( $classes ) 
	{
		global $post;

		$classes[] = str_replace('/', '-', self::template());

		if ( isset( $post ) ) 
		{
			$classes[] = $post->post_type . '-' . $post->post_name;
		}

		return $classes;
	}	


	//////////////////////////////////////////////////////////////////////////////////////////
	/// ENQUEUE METHODS
	//////////////////////////////////////////////////////////////////////////////////////////


	/**
	 * Enqueue theme scripts and styles
	 * @return [type] [description]
	 */
	public static function enqueue()
	{
		if( is_admin() ) return;

		// Load any config scripts/fonts
		Theme::scripts( Theme::config('scripts') );
		Theme::fonts( Theme::config('fonts') );
		Theme::styles( Theme::config('styles') );

		// Load Bootstrap
		Theme::script( 'bootstrap', array('source' => '/dist/bootstrap.js','footer' => TRUE));
		Theme::style(  'bootstrap', array('source' => '/dist/bootstrap.css','version'=> time()));

		// Load theme assets
		Theme::script( 'wptheme', array('source' => '/dist/theme.js','footer' => TRUE));
		Theme::style( 'wptheme', array( 'source' => '/dist/theme.css'));

		// Load template-specific scripts and styles if they exist
		$template = self::template();

		if( ! empty($template) ){

			if( $js = Theme::asset('js/' . $template . '.js') )
			{
				Theme::enqueue_script('template', array('source'=>$js) );
			}

			if( $css = Theme::asset('css/' . $template . '.css') )
			{
				Theme::enqueue_style('template', array('source'=>$css) );
			}
		}
		
	}

	/**
	 * Enqueue an array of scripts
	 * @param  [type] $scripts [description]
	 * @return [type]          [description]
	 */
	public static function scripts( $scripts )
	{
		foreach($scripts as $name => $script)
		{	
			Theme::script($name, $script);
		}
	}


	/**
	 * Enqueue a script
	 * @param  [type] $name   [description]
	 * @param  [type] $config [description]
	 * @return [type]         [description]
	 */
	public static function script( $name, $config = array() )
	{	
		// Check if already enqueued
		if( wp_script_is($name) ) return;

		// Get the soruce. If config is a string then it's passed in that way
		$uri = is_array($config) ? element($config, 'source', '') : $config;

		$src = Theme::src($uri);

		if( empty($src) ) return;

		// Get enqueue params
		$dependencies = element( $config, 'dependencies', array() );
		$version      = element( $config, 'version', NULL );
		$footer       = element( $config, 'footer', TRUE );

		// Enqueue the script
		wp_enqueue_script($name, $src, $dependencies, $version, $footer);

	}

	/**
	 * Enqueue an array of fonts
	 * @param  [type] $fonts [description]
	 * @return [type]        [description]
	 */
	public static function fonts( $fonts )
	{
		foreach($fonts as $font => $uri)
		{	
			Theme::font($font, $uri);
		}
	}


	/**
	 * Enqueue a font
	 * @param  [type] $name [description]
	 * @param  [type] $uri  [description]
	 * @return [type]       [description]
	 */
	public static function font( $name, $uri )
	{
		$name = $name . '-font';

		if( wp_style_is($name) ) return;

		$src  = Theme::src($uri);

		if( empty($src) ) return;

		// Enqueue as style
		wp_enqueue_style( $name, $src );
	}


	/**
	 * Enqueue an array of styles
	 * @param  [type] $styles [description]
	 * @return [type]         [description]
	 */
	public static function styles( $styles )
	{
		foreach($styles as $name => $style)
		{	
			Theme::style($name, $style);
		}
	}


	/**
	 * Enqueue a stylesheet
	 * @param  [type] $name   [description]
	 * @param  [type] $config [description]
	 * @return [type]         [description]
	 */
	public static function style( $name, $config = array() )
	{
		if( wp_style_is($name) ) return;

		// Get the soruce. If config is a string then it's passed in that way
		$uri = is_array($config) ? element($config, 'source', '') : $config;
	
		// Check for asset path
		$src  = Theme::src($uri);

		// Missing
		if( empty($src) ) return;

		// Get enqueue params
		$dependencies = element( $config, 'dependencies', array() );
		$version      = element( $config, 'version', NULL );
		$media        = element( $config, 'media', 'screen' );

		// Enqueue the style
		wp_enqueue_style( $name, $src, $dependencies, $version, $media );
	}


	/**
	 * Register custom post types
	 * @return [type] [description]
	 */
	public static function post_types()
	{

	}


	/**
	 * Register menus defined in theme.config.php
	 * @return [type] [description]
	 */
	public static function register_menus()
	{
		$menus = self::config('menus');

		if( empty($menus) ) return;

		foreach($menus as $menu => $label)
		{
			register_nav_menu($menu, __($label, THEME_DOMAIN) );
		}

	}

	/**
	 * Register sidebars defined in theme.config.php
	 * @return [type] [description]
	 */
	public static function register_sidebars()
	{
		$sidebars = self::config('sidebars');

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
		$widgets = self::config('widgets');

		if( empty($widgets) ) return;

		// If we have widgets, include the theme base widget class
		include THEME_DIR . '/library/classes/widget.php';

		foreach($widgets as $widget) 
		{
			$widget_file  = THEME_DIR . '/library/widgets/' . $widget . '.php';
			$widget_class = ucfirst($widget) . '_Widget';

			if( is_file($widget_file) ) 
			{
				include $widget_file;
				register_widget($widget_class);
			}
		}

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

			$slug = Theme::get_page_slug($id);

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
			} else if( Theme::template_exists('single') ) {
				$template = 'single';
			}

		// Archives
		} else if( is_archive() ) {

			if( ! empty($type) && is_post_type_archive($type) 
				&& Theme::view_exists('archive/'.$type) ){
				$template = 'archive/'.$type; 
			} else if ( Theme::template_exists('archive') ){
				$template = 'archive';
			}
		}


		// Set the template
		self::$template = $template;

		// Get the page content first, this allows it to load things into wp_head
		$body = self::view($template, array(), 1, TRUE);
		
		// This is where the rubber meets the road
		// Output header, page and footer
		self::$header && get_header();
		echo $body;
		self::$footer && get_footer();

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
		// If non-empty array, extract variables for the view
		if( ! empty($data) && is_array($data) ) 
		{
			foreach( $data as $key => $val )
			{
				// Convert simple items to item = TRUE
				if( is_int($key) ) {
					$data[$val] = TRUE;
					unset($data[$key]);
				}
			}
			extract($data, EXTR_SKIP);
		}

		// Append extension if needed
		if( substr($path, -4) != '.php' ) $path .= '.php';
		
		// Set absolute path
		$path = self::path( 'views/' . $path );

		// Warn if missing
		if( ! is_file($path) ) wp_die('Could not locate view:<br/><strong>' . $path . '</strong>');

		if( $return ) {
			ob_start();
		}

		// Include with repeat
		for( $i = 1; $i <= $repeat; $i++ ){
			$loop_total = $repeat;
			$loop_count = $i;
			include($path);
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
		Theme::view('partials/' . $path, $data, $repeat);
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
		// verify path
		$path = self::path($file);

		return ! empty($path);
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
	 * Add shortcodes specified in config
	 */
	public static function add_shortcodes()
	{
		$shortcodes = self::config('shortcodes');

		foreach($shortcodes as $shortcode)
		{
			$file = THEME_DIR . '/library/shortcodes/' . $shortcode . '.php';

			if( is_file($file) ) {
				include($file);
			}
		}
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