<?php




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
 * String starts with
 */
if( ! function_exists('str_starts_with') )
{
  function str_starts_with($haystack, $needle) 
  {
    return substr($haystack, 0, strlen($needle)) === $needle;
  }
}

/**
 * String ends with
 */
if( ! function_exists('str_ends_with') )
{
  function str_ends_with($haystack, $needle) 
  {
    return substr($haystack,-strlen($needle))===$needle;
  }
}

/**
 * Get theme asset URI
 * @param  string $path [description]
 * @return [type]       [description]
 */
function wpt_asset( string $path, $subdir = '' )
{
	$prefix = 'assets/';

	if( ! empty($subdir) )
	{
		$prefix .= rtrim($subdir,'/') . '/';
	}

  $path = '/' . wpt_prefix( ltrim($path,'/'), $prefix );

  return get_template_directory_uri() . $path;

}

/**
 * Get theme image
 * @param  string  $path [description]
 * @param  boolean $tag  [description]
 * @param  array   $attr [description]
 * @return [type]        [description]
 */
function wpt_image( string $path, $tag = TRUE, array $attr = array() )
{
	$url = wpt_asset( $path, 'images' );

	if( $tag )
	{
		return '<img src="' . $url .'" ' . wpt_attr($attr) . ' />';
	}

  return $url;
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



function wpt_labelize( $str )
{
  return ucwords(str_replace(['_','-'],' ',$str));
}



function wpt_slugify( $str )
{
  return strtolower(str_replace(' ','_',$str));
}
