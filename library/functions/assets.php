<?php if ( ! defined( 'ABSPATH' ) ) exit('Foolish Mortal'); 



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