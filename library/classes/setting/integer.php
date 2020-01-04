<?php 

namespace WPTheme\Setting;

use WPTheme\Setting;

class Integer extends Setting
{
  public function sanitize( $value )
  {
    return intval($value);
  }


  public function render_content()
  {
    $name = $this->input_name();
    $id = $this->input_id();
    echo '<input id="'.$id.'" name="'.$name.'" type="number" min="0" step="1" value="'.$this->value.'" />';
  }
}