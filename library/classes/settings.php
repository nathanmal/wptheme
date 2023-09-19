<?php

namespace WPTheme;

class Settings
{
  /**
   * Holds loaded settings
   * @var array
   */
  private static $settings = array();


  /**
   * Get setting
   * @param  string $name  The setting name
   * @return [type]        [description]
   */
  public function get( string $name, mixed $default = NULL ):mixed
  {
    $name = wpt_prefix( $option, 'wptheme_');

    // Lazy load options group
    if( ! isset(self::$settings[$name]) )
    {
      self::$settings[$name] = get_option($name, $default);
    }

    return self::$settings[$name];
  }

  /**
   * Update option
   * @param  string $option [description]
   * @param  mixed  $value  [description]
   * @return [type]         [description]
   */
  public function update( string $name, mixed $value ):bool
  {
    $name = wpt_prefix($name, 'wptheme_');

    if( update_option($name, $value) )
    {
      self::$settings[$name] = $value;

      return TRUE;
    }

    return FALSE;
  }

  /**
   * Delete an option
   * @param  string $option [description]
   * @return [type]         [description]
   */
  public function delete( string $name )
  {
    $name = wpt_prefix($name, 'wptheme_');

    if( delete_option($name) )
    {
      if( isset(self::$settings[$name])) unset(self::$settings[$name]);

      return TRUE;
    }

    return FALSE;
  }


}