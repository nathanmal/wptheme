<?php 


namespace WPTheme;


class Component
{

  public static $errors = array();

  public static $error = '';

  public static function error( $message = '' )
  {
    if( empty($message) )
    {
      return static::$error;
    }

    static::$error = $message;

    static::$errors[] = $message;

    static::log( $message, 'error' );
  }

  public static function get_error()
  {
    return static::$error;
  }

  public static function log( $message, $level = 'info' )
  {
    $header = '['.$level.']' . ' ' . get_called_class();

    error_log($header . ' ' . $message);
  }
}