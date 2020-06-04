<?php 

namespace WPTheme;

use WPTheme\Theme;

class Font
{
  
  public static function install( $family )
  {
    $fonts = Setting::get('fonts.installed', array() );

    if( empty($fonts) ) $fonts = array();

    if( isset($fonts[$family]) ) {

      Theme::error('Font already installed: ' . $family);
      return FALSE;
    }

    $key = Setting::get('fonts.google.apikey');

    $url = 'https://www.googleapis.com/webfonts/v1/webfonts?key='.$key;

    $json = file_get_contents($url);

    $data = json_decode($json);

    foreach($data->items as $item)
    {
      if( $item->family == $family )
      {
        $fonts[$family] = array(
          'item'=>$item,
          'enqueue' => array()
        );
      }
    }

    if( ! Setting::set('fonts.installed', $fonts) )
    {
      Theme::error('Could not update option');
      return FALSE;
    }

    return TRUE;
  }


  public static function remove( $family )
  {
    $fonts = Setting::get('fonts.installed', array() );

    if( isset($fonts[$family]) )
    {
      unset($fonts[$family]);

      if( ! Setting::set('fonts.installed', $fonts) )
      {
        Theme::error('Could not update option');
        return FALSE;
      }

      return TRUE;

    }

    Theme::error('Font not installed: ' . $family);
    return FALSE;
  }
}