<?php if ( ! defined( 'ABSPATH' ) ) exit('Foolish Mortal'); 



/**
 * PSR-4 Plugin autoloader
 * Used with spl_autoload_register
 * @see    http://php.net/manual/en/function.spl-autoload-register.php
 * @param  string $class Class name
 */
function wpt_autoload($class)
{ 
  //if( strpos($class, 'WPtheme\\') !== 0 ) return;
  if( 0 !== strpos($class, 'WPTheme\\') OR strlen($class) <= 8 ) return;

  $class = substr($class, 8);
  
  $library = THEME_DIR . '/library';

  if( $class === 'Theme' )
  {
    require $library . '/theme.php';
    return;
  }

  $path =  $library . '/classes/' . str_replace('\\','/',strtolower($class)) . '.php';

  if( is_file($path) ) 
  { 
    require $path;
  }

}


// Register theme autoloader
spl_autoload_register( 'wpt_autoload' );

/**
 * Get the theme singleton
 * @return [type] [description]
 */
function wpt()
{
  return \WPTheme\Theme::instance();
}



/**
 * Get the shortname of a namespaced class
 * @param  [type] $object [description]
 * @return [type]         [description]
 */
function wpt_class_shortname( $object )
{
  return is_object($object) ? (new \ReflectionObject($object))->getShortName() : '';
}



/**
 * Get the current page URL
 */
function wpt_current_url()
{
  global $wp;
  return home_url($wp->request);
}



/**
 * Get array of enqueued assets
 * @return [type] [description]
 */
function wpt_enqueued()
{
    global $wp_scripts, $wp_styles;

    $list = array('scripts'=>[],'styles'=>[]);

    foreach( $wp_scripts->queue as $script )
        $list['scripts'][] = $wp_scripts->registered[$script];

    foreach( $wp_styles->queue as $style)
        $list['styles'][] = $wp_styles->registered[$style];

    return $list;

}



/**
 * Get core setting
 * @param  [type]  $key     [description]
 * @param  boolean $default [description]
 * @return [type]           [description]
 */
function wpt_setting($key, $default = FALSE)
{
    return WPTheme\Setting::get($key, $default);
}

