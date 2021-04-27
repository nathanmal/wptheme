<?php

namespace WPTheme;

class Option
{
  /**
   * Holds loaded options
   * @var array
   */
  private static $options = array();


  /**
   * Get an options group
   * @param  string $group [description]
   * @return [type]        [description]
   */
  public function group( string $group )
  {
    // Group must be present
    if( empty($group) ) return FALSE;

    // Prefix group name
    $group = 'wptheme_' . $group;

    // Lazy load options group
    if( ! isset(Option::$options[$group]) )
    {
      Option::$options[$group] = get_option($group, array());
    }

    // Return the entire group
    return Option::$options[$group];
  }

  /**
   * Update options group
   * @param  string $group  [description]
   * @param  array  $values [description]
   * @return [type]         [description]
   */
  public function update_group( string $group, array $values )
  {
    // Group must be present
    if( empty($group) ) return FALSE;

    // Prefix group name
    $group = 'wptheme_' . $group;

    if( update_option( $group, $values ) )
    {
      Option::$options[$group] = $values;

      return TRUE;
    }

    return FALSE;
  }

  /**
   * Prefix option name
   * @param  string $option [description]
   * @return [type]         [description]
   */
  public function name( string $option )
  {
    return str_prefix( $option, 'wpt_' );
  }

  /**
   * Get option
   * @param  string $option [description]
   * @return [type]         [description]
   */
  public function get( string $option, mixed $default = NULL, string $group = 'options' )
  {
    // Group must be present
    if( empty($group) ) return FALSE;

    // Prefix group name
    $group = 'wptheme_' . $group;

    // Lazy load options group
    if( ! isset(Option::$options[$group]) )
    {
      Option::$options[$group] = get_option($group, array());
    }

    return Option::$options[$group][$option] ?? $default;
  }

  /**
   * Update option
   * @param  string $option [description]
   * @param  mixed  $value  [description]
   * @return [type]         [description]
   */
  public function update( string $option, mixed $value, string $group = 'options' )
  {
    // Group must be present
    if( empty($group) ) return FALSE;

    // Prefix group name
    $group = 'wptheme_' . $group;

    // Load group if not loaded
    if( ! isset(Option::$options[$group]) )
    {
      Option::$options[$group] = get_option($group, array());
    }

    // Set new value
    Option::$options[$group][$option] = $value;

    // Save option group
    return update_option($group, Option::$options[$group]);
  }

  /**
   * Delete an option
   * @param  string $option [description]
   * @return [type]         [description]
   */
  public function delete( string $option, string $group = 'options' )
  {
    // Group must be present
    if( empty($group) ) return FALSE;

    // Prefix group name
    $group = 'wptheme_' . $group;

    // Load group if not loaded
    if( ! isset(Option::$options[$group]) )
    {
      Option::$options[$group] = get_option($group, array());
    }

    // Delete option from group
    if( isset(Option::$options[$group][$option]) )
    {
      unset(Option::$options[$group][$option]);
    }

    // Save option group
    return update_option($group, Option::$options[$group]);
  }

  /**
   * Delete an entire option group
   * @param  string $group [description]
   * @return [type]        [description]
   */
  public function delete_group( string $group = 'options' )
  {
    // Group must be present
    if( empty($group) ) return FALSE;

    // Prefix group name
    $group = 'wptheme_' . $group;

    // Delete the option group
    delete_option($group);
  }

}
