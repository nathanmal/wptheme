<?php 

namespace WPTheme;

use WPTheme\Component;

class Font extends Component
{





  public static function install( $family )
  {
    $fonts = Settings::get('fonts.installed', array() );

    if( empty($fonts) ) $fonts = array();

    if( isset($fonts[$family]) ) {

      Font::error('Font already installed: ' . $family);
      return FALSE;
    }

    $key = Settings::get('fonts.google.apikey');

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

    if( ! Settings::update('fonts.installed', $fonts) )
    {
      Font::error('Could not update option');
      return FALSE;
    }

    return TRUE;
  }


  public static function remove( $family )
  {
    $fonts = Settings::get('fonts.installed', array() );

    if( isset($fonts[$family]) )
    {
      unset($fonts[$family]);

      if( ! Settings::update('fonts.installed', $fonts) )
      {
        Font::error('Could not update option');
        return FALSE;
      }

      return TRUE;

    }

    Font::error('Font not installed: ' . $family);
    return FALSE;
  }
}