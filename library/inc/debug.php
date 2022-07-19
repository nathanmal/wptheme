<?php if ( ! defined( 'ABSPATH' ) ) exit('Foolish Mortal'); 

/**
* Print out an variable in a <pre></pre> block
* @param  [type] $obj [description]
* @return [type]      [description]
*/
if( ! function_exists('pre') ) 
{
  function pre($obj)
  {
      echo '<div class="pre-debug"><pre>';
      if( is_array($obj) ) {
          print_r($obj);
      } else {
          var_dump($obj);
      }
      echo '</pre></div>';
  }
}

/**
 * Log a variable
 * @param  [type] $var [description]
 * @return [type]      [description]
 */
function wpt_log( $var )
{
  if( is_object($var) OR is_array($var) )
  {
    $var = print_r($var,TRUE);
  }

  if( defined('WP_DEBUG_LOG') && is_file(WP_DEBUG_LOG) )
  {
    error_log($var, 3, WP_DEBUG_LOG);
  }
  else
  {
    error_log($var);
  }
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

    if( ! empty($class) )
    {
      $str .= $class . '::';
    }

    if( ! empty($function) )
    {
      $str .= $function . '()';
    }

    $out[] = $str;

  }

  return $out;
}
