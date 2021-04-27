<?php 

namespace WPTheme\Setting;

use WPTheme\Setting;
use WPTheme\Setting\Text;

class Email extends Text
{
  public function sanitize( $value )
  {
    return sanitize_email($value);
  }
}