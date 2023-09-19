<?php if ( ! defined( 'ABSPATH' ) ) exit('Foolish Mortal'); 

function wpt_settings_pages()
{
	return apply_filters('wpt_settings_pages', ['settings','styles']);
}