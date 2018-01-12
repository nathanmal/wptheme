<?php 


if( ! function_exists('wptheme_template_exists') )
{
	function wptheme_template_exists($name)
	{
		return file_exists( 'views/templates/' . $name . '.php' );
	}
}

if( ! function_exists('wptheme_load_template') )
{
	function wptheme_load_template($name)
	{
		include( 'views/templates/' . $name . '.php' );
	}
}