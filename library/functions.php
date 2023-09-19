<?php
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
  
  $path =  WPT_LIB . '/classes/' . str_replace('\\','/',strtolower($class)) . '.php';

  require_once($path);
}


// Register theme autoloader
spl_autoload_register( 'wpt_autoload' );


// Core functions
require_once('functions/core.php');
require_once('functions/strings.php');
require_once('functions/assets.php');
require_once('functions/templates.php');
require_once('functions/content.php');