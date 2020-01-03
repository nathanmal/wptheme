<?php 

namespace WPTheme;

use WPTheme\Package;
use WPTheme\Setting;
use WPTheme\Component;

class Settings extends Component
{

  protected static $page = '';



  protected static $screen = '';

  /**
   * Holds registered settings
   * @var array
   */
  protected static $registered = array();

  /**
   * Holds data loaded from options table
   * @var array
   */
  protected static $cache = array();


  /**
   * Set to true if settings form submitted
   * @var boolean
   */
  protected static $updating = FALSE;

  /**
   * Holds notices
   * @var array
   */
  protected static $notices = array();

  protected static $input = array();



  protected static $enabled = array(
    'general',
    'assets',
    'integrations',
    'contact'
  );

  protected static $tabs = array();


  protected static $pages = array();


  /**
   * Initilize settings
   * @return [type] [description]
   */
  public static function init()
  { 
    // Enqueue scripts
    Settings::enqueue();

    // Add Admin Menus
    Settings::add_menus();

    // Set page
    Settings::$screen = element($_GET, 'page');

    $name = substr(Settings::$screen, strpos(Settings::$screen,'.') + 1 );

    // Load settings page
    Settings::$page = Settings::load($name);

    if( ! empty($_POST) && isset($_POST['submit']) )
    {
      $nonce = element($_POST,'nonce');

      if( ! wp_verify_nonce($nonce,'wpt-settings') )
      {
        Settings::error('Could not validate nonce');
      }
      else
      {

        Settings::$updating = TRUE;

        Settings::$input = element($_POST, 'settings', array());
      }
    }
  
  }


  /**
   * Get a setting value
   * @param  [type]  $key     [description]
   * @param  boolean $default [description]
   * @return [type]           [description]
   */
  public static function get( $key, $default = FALSE )
  { 
    // Non-persistent caching
    if( ! isset( Settings::$cache[$key]) )
    {
      Settings::$cache[$key] = get_option('wpt.'.$key, $default );
    }

    return Settings::$cache[$key];
  }


  /**
   * Update a setting value
   * 
   * @param  [type] $key   [description]
   * @param  [type] $value [description]
   * @return [type]        [description]
   */
  public static function update( $key, $value )
  {
    // Update the option and if successful, the cache
    if( update_option( 'wpt.' . $key , $value ) )
    {
      Settings::$cache[$key] = $value;

      return TRUE;
    }

    return FALSE;
  }


  public static function wpt_save_metabox()
  {
    global $hook_suffix;

   
  }

  public static function wpt_submit_meta_box()
  {
    $reset_url = '#';

    ?>
    <div id="submitpost" class="submitbox">

        <div id="major-publishing-actions">
            
            <div id="delete-action">
                <a href="<?php echo esc_url( $reset_url ); ?>" class="submitdelete deletion">Reset Settings</a>
            </div><!-- #delete-action -->

            <div id="publishing-action">
                <span class="spinner"></span>
                <?php submit_button( esc_attr( 'Save' ), 'primary', 'submit', false );?>
            </div>

            <div class="clear"></div>

        </div><!-- #major-publishing-actions -->

    </div><!-- #submitpost -->

    <?php
  }

  public static function wpt_screen_layout_column( $columns, $screen )
  {
    return $columns;
  }


  public static function enqueue()
  {
    wp_enqueue_script( 'common' );
    wp_enqueue_script( 'wp-lists' );
    wp_enqueue_script( 'postbox' );
    add_thickbox();
  }


  public static function add_menus()
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

    foreach( Settings::$enabled as $name )
    {
      add_submenu_page( 
        'wptheme', 
        ucfirst($name), 
        ucfirst($name), 
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
    return element(Settings::$input, $key);
  }
  

  /**
   * Register a setting
   * @param  [type] $key     [description]
   * @param  [type] $setting [description]
   * @return [type]          [description]
   */
  public static function register( $key, $setting = NULL )
  {
    if( isset(Settings::$registered[$key]) ) 
    {
      wp_die('Setting is already registered: ' . $key);
    }

    if( empty($setting) OR ! is_a($setting, '\\WPTheme\\Setting') )
    {
      wp_die('Setting must be instance of WPTheme\\Setting class');
    }

    Settings::$registered[$key] = $setting;

  }


  



  public static function load( $name )
  {
    $class = '\\WPTheme\\Settings\\' . ucfirst($name);

    if( class_exists($class) )
    {
      return new $class;
    }

    return NULL;
  }

  public static function notice( $message, $type = 'info', $dismissable = TRUE )
  {
    Settings::$notices[] = array($message, $type, $dismissable);
  }

  public static function render_notice( $message, $type = 'info', $dismissable = TRUE )
  {
    $class = 'notice notice-' . $type . ( $dismissable ? ' is-dismissible' : '');
    $button = $dismissable ? '<button type="button" class="notice-dismiss">
                <span class="screen-reader-text">Dismiss this notice.</span>
              </button>' : '';

    echo '<div class="'.$class.'"><p><strong>'.$message.'</strong></p>'.$button.'</div>';
  }


  public static function add_save_metabox()
  {
    global $hook_suffix;

    add_meta_box(
        'submitdiv',               /* Meta Box ID */
        'Save Options',            /* Title */
        array(__CLASS__,'wpt_submit_meta_box'),  /* Function Callback */
        Settings::$screen,                /* Screen: Our Settings Page */
        'side',                    /* Context */
        'high'                     /* Priority */
    );
  }

  public static function _render()
  { 
    global $hook_suffix;

    Settings::add_save_metabox();
    
    Settings::$page->add_meta_boxes();

    $action = admin_url('admin.php?page=' . Settings::$screen);

    ?>
    <div id="wpt-settings" class="wrap">
        
        <h2><?= Settings::$page->title() ?></h2>

        <?php 

        if( ! empty(Settings::$notices) )
        {
          foreach(Settings::$notices as $notice)
          {
            list($message,$type,$dismissable) = $notice;

            Settings::render_notice($message, $type, $dismissable);
          }
        }
        ?>

  
        <div class="wpt-settings-meta-box-wrap">

            <form id="wpt-settings-form" method="post" action="<?= $action ?>">

                <?php //settings_fields( 'fx_smb' ); // options group  ?>
                <?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
                <?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>

                <div id="poststuff">

                    <div id="post-body" class="metabox-holder columns-<?php echo 1 == get_current_screen()->get_columns() ? '1' : '2'; ?>">

                        <div id="postbox-container-1" class="postbox-container">
                            <?php do_meta_boxes( Settings::$screen, 'side', null ); ?>
                            <!-- #side-sortables -->

                        </div><!-- #postbox-container-1 -->

                        <div id="postbox-container-2" class="postbox-container">

                            <?php do_meta_boxes( Settings::$screen, 'normal', null ); ?>
                            <!-- #normal-sortables -->

                            <?php do_meta_boxes( Settings::$screen, 'advanced', null ); ?>
                            <!-- #advanced-sortables -->

                        </div><!-- #postbox-container-2 -->

                    </div><!-- #post-body -->

                    <br class="clear">

                </div><!-- #poststuff -->
            

            <input type="hidden" id="wpt-settings-nonce" name="nonce" value="<?=wp_create_nonce('wpt-settings')?>" />
            </form>

        </div><!-- .wpt-settings-meta-box-wrap -->

    </div><!-- .wrap -->
    

    <?php 


    pre($_POST);
  }

  public static function _render2()
  { 

    $page = Settings::$page;

    $settings = Settings::load( $page );

    if( empty($settings) )
    {
      // Page wrapper
      echo '<div id="wpt-settings" class="wrap">';
      echo Settings::notice( 'Settings not found: ' . $page, 'error' );
      echo '</div>';
    
      return;
    }

    // Page wrapper
    echo '<div id="wpt-settings" class="wrap">';
    
    // Main Form
    echo '<form action="' . Settings::url(Settings::$page) . '" method="post">';
    
    ?>
    
    <div class="wpt-settings-header">
      <div class="wpt-settings-title">
        <h1>
        <span class="dashicons dashicons-admin-generic"></span>
        <?= $settings->title() ?>
        </h1>
      </div>
      <ul class="wpt-settings-menu">
          <?php foreach(Settings::$pages as $name => $page) { 
          $active = $name == Settings::$page ? 'active' : '';
          ?> 
          <li class="<?=$active?>"><a href="<?= admin_url('admin.php?page=wptheme.' . $name) ?>"><?= $page->title() ?></a></li>
          <?php } ?>
      </ul>

    </div>


    <?php 

    if( ! empty(Settings::$error) )
    {
      echo Settings::notice( Settings::$error, 'error' );
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



  public function __construct()
  {
    if( empty($this->title) )
    {
      $this->title = get_class_shortname($this);
    }

    add_action( 'add_meta_boxes', array($this, 'add_meta_boxes') );


    $this->setup();
    
  }

  public function setup()
  {

  }


  public function register_settings()
  {

  }


  public function add_meta_boxes()
  {

  }



  public function render()
  {
    echo Settings::notice('Missing settings render function','error');
  }


  public function title()
  {
    return $this->title;
  }



  public function do_setting( $name, $type, $label, $config = array() )
  {
    $config['label'] = $label;

    $setting = Setting::factory($name, $type, $config);

    if( Settings::$updating )
    {
      $updated = $setting->update( element( Settings::$input, $name ) );
    }

    $setting->render();

    return;

  }


  public function get_setting( $name )
  {
    return element( Settings::$registered, $name );
  }

}