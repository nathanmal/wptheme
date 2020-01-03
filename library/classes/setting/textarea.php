<?php 

namespace WPTheme\Setting;

use WPTheme\Setting;

class Textarea extends Setting
{

  public function sanitize( $value )
  {
    return sanitize_textarea_field($value);
  }

  public function render_content()
  {
    $name = $this->input_name();
    $id   = $this->input_id();
    echo '<textarea id="'.$id.'" name="'.$name.'" class="widefat" rows="12">' . $this->value .'</textarea>';
  }
}