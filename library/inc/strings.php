<?php if ( ! defined( 'ABSPATH' ) ) exit('Foolish Mortal'); 

/**
 * Enforce prefix on string
 * @param  string $str    [description]
 * @param  string $prefix [description]
 * @return [type]         [description]
 */
function wpt_prefix( string $str, string $prefix )
{
  return str_starts_with( $str, $prefix ) ? $str : $prefix . $str;
}


/**
 * Enforce suffix on a string
 * @param  string $str    [description]
 * @param  string $suffix [description]
 * @return [type]         [description]
 */
function wpt_suffix( string $str, string $suffix )
{
  return str_ends_with($str,$suffix) ? $str : $str . $suffix;
}


/**
 * String starts with - polyfill for PHP 8.0 function
 */
if( ! function_exists('str_starts_with') )
{
  function str_starts_with($haystack, $needle) 
  {
    return substr($haystack, 0, strlen($needle)) === $needle;
  }
}

/**
 * String ends with - polyfill for PHP 8.0 function
 */
if( ! function_exists('str_ends_with') )
{
  function str_ends_with($haystack, $needle) 
  {
    return substr($haystack,-strlen($needle))===$needle;
  }
}


/**
 * Turn a slug into a label
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function wpt_labelize( $str )
{
  return ucwords(str_replace(['_','-'],' ',$str));
}


/**
 * Turn a label into a slug
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function wpt_slugify( $str )
{
  return strtolower(str_replace(' ','_',$str));
}
