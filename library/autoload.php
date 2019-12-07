<?php
 

/**
 * PSR-4 Plugin autoloader
 * Used with spl_autoload_register
 * @see    http://php.net/manual/en/function.spl-autoload-register.php
 * @param  string $class Class name
 */
function wptheme_autoload($class)
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