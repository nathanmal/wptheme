<?php 

namespace WPTheme\Admin\Setting;

use WPTheme\Admin\Setting;
use WPTheme\Setting\Text;

class Email extends Text
{
  public function sanitize( $value )
  {
    return sanitize_email($value);
  }
}