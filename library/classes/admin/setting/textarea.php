<?php 

namespace WPTheme\Admin\Setting;

use WPTheme\Admin\Setting;

class Textarea extends Setting
{

  public function sanitize( $value )
  {
    return sanitize_textarea_field($value);
  }

  public function render()
  {
    $name = $this->input_name();
    $id   = $this->input_id();
    echo '<textarea id="'.$id.'" name="'.$name.'" class="widefat" rows="12">' . $this->value .'</textarea>';
  }
}