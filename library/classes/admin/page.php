<?php 

namespace WPTheme\Admin;

use WPTheme\Theme;
use WPTheme\Setting;

/**
 * Settings Page
 */
class Page
{

  /**
   * The page slug used in URL string
   * @var string
   */
  protected static $slug = '';

  /**
   * Current page
   * @var string
   */
  protected static $current = '';

  /**
   * Current screen
   * @var string
   */
  protected static $screen = '';

  /**
   * Holds notices
   * @var array
   */
  protected static $notices = array();

  /**
   * Input data from POST
   * @var array
   */
  protected static $input = array();


  /**
   * Enabled pages
   * @var array
   */
  protected static $enabled = array(
    'general',
    'assets',
    'integrations',
    'contact'
  );

  /**
   * Current tabs
   * @var array
   */
  protected static $tabs = array();

  /**
   * Page instances
   * @var array
   */
  protected static $pages = array();

  /**
   * Initilize settings
   * @return [type] [description]
   */
  public static function init()
  { 
    // Enqueue scripts
    Page::enqueue();

    // Get pages
    $files = list_files( THEME_DIR .'/library/classes/admin/page', 1 );

    foreach($files as $file)
    {
      $slug = pathinfo($file, PATHINFO_FILENAME);

      Page::$pages[$slug] = Page::load($slug);
    }

    // Sort pages by menu_order
    uasort( Page::$pages, array( __CLASS__, 'sort' ) );

    // Add Admin Menus
    Page::menus();

    // Set current page and process input
    if( $slug = element($_GET, 'page') )
    {
      Page::$current = (0 === strpos($slug, 'wptheme.')) ? substr($slug, 8) : $slug;

      // Run page scripts
      if( $current = Page::current() ) $current->process();
    }

  }

  /**
   * Sort settings pages by their $menu_order property
   * @param  [type] $p1 [description]
   * @param  [type] $p2 [description]
   * @return [type]     [description]
   */
  public static function sort( $p1, $p2 )
  {
    if( $p1->menu_order == $p2->menu_order ) return 0;

    return $p1->menu_order < $p2->menu_order ? -1 : 1;
  }

  /**
   * Load admin page
   * @param  [type] $name [description]
   * @return [type]       [description]
   */
  public static function load( $name )
  { 
    if( 0 === strpos($name, 'wptheme.') ) $name = substr($name, 8);

    $class = '\\WPTheme\\Admin\\Page\\' . ucfirst($name);

    $page = class_exists($class) ? new $class : NULL;

    // Make sure page was loaded
    if( empty($page) )
    {
      Theme::error('Admin settings page not found: ' . Page::$current);
    }

    return $page;
  }


  /**
   * Get the current page
   * @return [type] [description]
   */
  public static function current()
  {
    return element( Page::$pages, Page::$current );
  }

  
  /**
   * Render save metabox 
   * @return [type] [description]
   */
  public static function metabox_save()
  {
    $reset_url = '#';

    ?>
    <div id="submitpost" class="submitbox">

        <div id="major-publishing-actions">
            
            <!--
            <div id="delete-action">
                <a href="<?php echo esc_url( $reset_url ); ?>" class="submitdelete deletion">Reset Settings</a>
            </div>
            -->
            <!-- #delete-action -->

            <div id="publishing-action">
                <span class="spinner"></span>
                <?php submit_button( esc_attr( 'Update Settings' ), 'primary', 'submit', false );?>
            </div>

            <div class="clear"></div>

        </div><!-- #major-publishing-actions -->

    </div><!-- #submitpost -->

    <?php
  }


  /**
   * Enqueue common scripts and styles
   * @return [type] [description]
   */
  public static function enqueue()
  {
    wp_enqueue_script( 'common' );
    wp_enqueue_script( 'wp-lists' );
    wp_enqueue_script( 'postbox' );
    add_thickbox();
  }

  /**
   * Add menus
   * @return [type] [description]
   */
  public static function menus()
  {
    // Main plugin menu
    add_menu_page(
      'WPTheme',
      'WPTheme',
      'manage_options',
      'wptheme',
      array( __CLASS__, '_render' ), 
      NULL, // Icon
      '79'
    );

    foreach( Page::$pages as $name => $page )
    {
  
      add_submenu_page( 
        'wptheme', 
        $page->title(), 
        $page->title(), 
        'manage_options', 
        'wptheme.'.$name, 
        array(__CLASS__, '_render')
      );
    }

    // Remove duplicate top level menu item
    remove_submenu_page('wptheme','wptheme');

  }

  /**
   * Get group name for setting, if any
   * @param  [type] $name [description]
   * @return [type]       [description]
   */
  public static function group( $name )
  {
    return FALSE !== strpos($name, '.') ? substr($name,0,strpos($name,'.')) : '';
  }

  /**
   * Get POST value
   *
   * returns NULL if value not set
   * 
   * @param  [type] $key [description]
   * @return [type]      [description]
   */
  public static function input( $key )
  {
    return element(Page::$input, $key);
  }
  

  /**
   * Add admin notice
   * @param  [type]  $message     [description]
   * @param  string  $type        [description]
   * @param  boolean $dismissable [description]
   * @return [type]               [description]
   */
  public static function notice( $message, $type = 'info', $dismissable = TRUE )
  {
    Page::$notices[] = array($message, $type, $dismissable);
  }

  /**
   * Render notices
   * @return [type] [description]
   */
  public static function render_notices()
  {
    if( ! empty(Page::$notices) )
    {
      foreach(Page::$notices as $notice)
      {
        list($message,$type,$dismissable) = $notice;

        Page::render_notice($message, $type, $dismissable);
      }
    }
  }
  /**
   * Render admin notice
   * @param  [type]  $message     [description]
   * @param  string  $type        [description]
   * @param  boolean $dismissable [description]
   * @return [type]               [description]
   */
  public static function render_notice( $message, $type = 'info', $dismissable = TRUE )
  {
    $class  = 'notice notice-' . $type . ( $dismissable ? ' is-dismissible' : '');

    echo '<div class="'.$class.'"><p><strong>'.$message.'</strong></p>';

    if( $dismissable )
    {
      echo '<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>';
    }

    echo '</div>';
  }

  /**
   * Add the save metabox
   */
  public static function add_save_metabox()
  {
    add_meta_box(
        'submitdiv',               /* Meta Box ID */
        'Save Settings',            /* Title */
        array(__CLASS__,'metabox_save'),  /* Function Callback */
        Page::$current,                /* Screen: Our Settings Page */
        'side',                    /* Context */
        'high'                     /* Priority */
    );
  }

  /**
   * Global render function
   * @return [type] [description]
   */
  public static function _render()
  { 
    global $hook_suffix;

    Page::add_save_metabox();

    $page = Page::current();
    
    $page->add_meta_boxes();

    $action = admin_url('admin.php?page=' . Page::$current);

    pre($action);

    ?>
    <div id="wpt-settings" class="wrap">
        
        <h2><?= $page->title() ?></h2>

        <?php Page::render_notices(); ?>
  
        <div class="wpt-settings-meta-box-wrap">

            <form id="wpt-settings-form" method="post" action="<?= $action ?>">

                <?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
                <?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>

                <div id="poststuff">

                    <div id="post-body" class="metabox-holder columns-<?php echo 1 == get_current_screen()->get_columns() ? '1' : '2'; ?>">

                        <div id="postbox-container-1" class="postbox-container">
                            <?php do_meta_boxes( Page::$current, 'side', null ); ?>
                            <!-- #side-sortables -->
                        </div><!-- #postbox-container-1 -->

                        <div id="postbox-container-2" class="postbox-container">

                            <?php do_meta_boxes( Page::$current, 'normal', null ); ?>
                            <!-- #normal-sortables -->

                            <?php do_meta_boxes( Page::$current, 'advanced', null ); ?>
                            <!-- #advanced-sortables -->

                        </div><!-- #postbox-container-2 -->

                    </div><!-- #post-body -->

                    <br class="clear">

                </div><!-- #poststuff -->
            
            <input type="hidden" id="wpt-settings-nonce" name="wpt-nonce" value="<?=wp_create_nonce('wpt-update')?>" />
            </form>

        </div><!-- .wpt-settings-meta-box-wrap -->

    </div><!-- .wrap -->
    

    <?php 

    if(! empty($_POST) ) pre($_POST);
  }





  

  public static function _render2()
  { 

    $page = Page::$current;

    $settings = Page::load( $page );

    if( empty($settings) )
    {
      // Page wrapper
      echo '<div id="wpt-settings" class="wrap">';
      echo Page::notice( 'Settings not found: ' . $page, 'error' );
      echo '</div>';
    
      return;
    }

    // Page wrapper
    echo '<div id="wpt-settings" class="wrap">';
    
    // Main Form
    echo '<form action="' . Page::url(Page::$current) . '" method="post">';
    
    ?>
    
    <div class="wpt-settings-header">
      <div class="wpt-settings-title">
        <h1>
        <span class="dashicons dashicons-admin-generic"></span>
        <?= $settings->title() ?>
        </h1>
      </div>
      <ul class="wpt-settings-menu">
          <?php foreach(Page::$currents as $name => $page) { 
          $active = $name == Page::$current ? 'active' : '';
          ?> 
          <li class="<?=$active?>"><a href="<?= admin_url('admin.php?page=wptheme.' . $name) ?>"><?= $page->title() ?></a></li>
          <?php } ?>
      </ul>

    </div>


    <?php 

    if( ! empty(Page::$error) )
    {
      echo Page::notice( Page::$error, 'error' );
    }

    // Render the page
    $settings->render();

    echo '<input type="hidden" id="wpt-settings-nonce" name="nonce" value="' . wp_create_nonce('wpt-settings').'" />';

    submit_button( 'Save Settings' );

    // Closing tags
    echo '</form>';

    echo '</div>';


   
  }

  public static function url( $page = 'general', $params = array() )
  {
    $url = 'admin.php?page=wptheme.' . $page;

    if( ! empty($params) )
    {
      $url .= '&' .  http_build_query($params);
    }

    return admin_url($url);
  }

  /**
   * Menu order, 0 = highest
   * @var integer
   */
  public $menu_order = 0;


  /**
   * Set to true if settings form submitted
   * @var boolean
   */
  public $updating = FALSE;



  /**
   * Registered settings for this page
   * @var array
   */
  public $settings = array();


  /**
   * Page metaboxes
   * @var array
   */
  public $metaboxes = array();


  /**
   * Settings page constructor
   */
  public function __construct()
  {
    // Make sure title is set
    if( empty($this->title) ) $this->title = get_class_shortname($this);

    

  }


  public function process()
  {
    // Add meta boxes
    add_action( 'add_meta_boxes', array($this, 'add_meta_boxes') );

    // Register settings
    $this->register_settings();

    // Check for post update
    if( ! empty($_POST) && isset($_POST['wpt-submit']) )
    { 
      // Set updating
      $this->updating = TRUE;

      // Set input
      $this->input    = element($_POST, 'wpt-settings', array());

      // Set nonce
      $this->nonce    = element( $_POST, 'wpt-nonce' );

      // Process input
      $this->update();
    }
  }

  /**
   * Register page settings
   * @return [type] [description]
   */
  public function register_settings(){}


  /**
   * Render a setting
   *
   * Will automatically update the setting if was input by user
   * 
   * @param  [type] $name   [description]
   * @param  [type] $type   [description]
   * @param  [type] $label  [description]
   * @param  array  $config [description]
   * @return [type]         [description]
   */
  public function register_setting( $name, $type, $label = '', $config = array() )
  {
    // Set label
    $config['label'] = empty($label) ? ucwords( str_replace(array('-','_'),' ',$name) ) : $label;

    // Create setting object
    $setting = Setting::factory($name, $type, $config);
    
    // Add setting to page
    $this->settings[$name] = $setting;

    return;
  }


  /**
   * Update page settings
   * @return [type] [description]
   */
  public function update()
  {
    // nonce check
    if( ! wp_verify_nonce( $this->nonce, 'wpt-update' ) ) 
    {
      Theme::error('Nonce verification failed');
      return FALSE;
    }

    // update registered settings
    foreach($this->settings as $name => $setting )
    {
      $value = element( $this->input, $name );

      $setting->update( $value );
    }

  }


  /**
   * Add page metaboxes
   *
   * @see https://developer.wordpress.org/reference/functions/add_meta_box/
   */
  public function add_meta_boxes()
  {
    foreach( $this->metaboxes as $name => $config )
    { 
      // Metabox ID
      $id       = 'wpt-' . $name;
      // Metabox Title
      $title    = element($config,'title', ucfirst(str_replace(array('-','_'),' ',$name)));
      // Context
      $context  = element($config,'context','normal');
      // Priority in context
      $priority = element($config,'priority','high');
      // Callback function
      $cb       = array($this, 'metabox_' . str_replace('-','_',$name) );

      add_meta_box( $id, $title, $cb, Page::$current, $context, $priority );
    }
  }


  /**
   * Get the page title
   * @return [type] [description]
   */
  public function title()
  {
    return $this->title;
  }

  /**
   * Render a setting
   *
   * Will automatically update the setting if was input by user
   * 
   * @param  [type] $name   [description]
   * @param  [type] $type   [description]
   * @param  [type] $label  [description]
   * @param  array  $config [description]
   * @return [type]         [description]
   */
  public function render_setting( $name )
  {
    $setting = $this->setting($name);

    if( $setting ) 
    {
      $setting->render();
    }
    else
    {
      '[Setting not registered: ' . $name;
    }
  }

  /**
   * Get setting
   * @param  [type] $name [description]
   * @return [type]       [description]
   */
  public function setting( $name )
  {
    return element( $this->settings, $name );
  }

}