<?php if ( ! defined( 'ABSPATH' ) ) exit('Foolish Mortal'); 

/**
 * Fetch an element from an array, allowing multidimentional search with . separators
 * @param  [type] &$array  [description]
 * @param  [type] $key     [description]
 * @param  [type] $default [description]
 * @return [type]          [description]
 */
function wpt_element( &$array, $key, $default=NULL )
{
  if( $p = strpos($key, '.') )
  {
    $c = substr($key, 0, $p); $n = substr($key, $p+1);

    return ( isset($array[$c]) && is_array($array[$c]) ) ? wpt_element( $array[$c], $n, $default ) : $default;
  }

  return ( is_array($array) && isset($array[$key]) ) ? $array[$key] : $default;
}
