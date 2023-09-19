<?php

namespace WPTheme\Traits;

use \_doing_it_wrong;

trait Singleton
{
  /**
   * The singleton instance
   */
  private static $instance;

  /**
   * Get instance
   */
  public static function instance()
  {
    if( ! self::$instance )
    {
      self::$instance = new self();
    }

    return self::$instance;
  }

  /**
   * Prevent cloning of the singleton
   */
  public function __clone()
  {
    _doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'kinkpress' ), '1.0.0' );
  }

  /**
   * Prevent serialization of the singleton
   */
  public function __sleep()
  {
    _doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'kinkpress' ), '1.0.0' );
  }

  /**
   * Prevent deserialization of the singleton
   */
  public function __wakeup()
  {
    _doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'kinkpress' ), '1.0.0' );
  }


}