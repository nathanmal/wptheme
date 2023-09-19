<?php if ( ! defined( 'ABSPATH' ) ) exit('Foolish Mortal'); 





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



/**
 * Log a variable
 * @param  [type] $var [description]
 * @return [type]      [description]
 */
function wpt_log( $var )
{
  if( is_object($var) OR is_array($var) ) $var = print_r($var,TRUE);

  return defined('WP_DEBUG_LOG') && is_file(WP_DEBUG_LOG) ? error_log($var, 3, WP_DEBUG_LOG) : error_log($var);
  
}


/**
 * Get backtrace array
 * @return [type] [description]
 */
function wpt_backtrace()
{
  $trace = debug_backtrace();
  $out   = [];

  foreach($trace as $item)
  {
    $class = $item['class'] ?? '';
    $func  = $item['function'] ?? '';
    $file  = $item['file'] ?? '';
    $line  = $item['line'] ?? '';

    $str = $file . ':' . $line . ' ';

    if( ! empty($class) ) $str .= $class . '::';
 
    if( ! empty($function) ) $str .= $function . '()';

    $out[] = $str;

  }

  return $out;
}

