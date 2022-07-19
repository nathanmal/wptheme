<?php 

namespace WPTheme\Admin\Setting;

use WPTheme\Admin\Setting;

class Boolean extends Setting
{
  public function sanitize( $value )
  {
    return !! $value;
  }
  
  public function render()
  {
    $checked = !! $this->value ? 'checked' : '';
    $name = $this->input_name();
    $id = $this->input_id();

    echo '<label for="' .$id.'">';
    echo '<input id="'.$id.'" name="'.$name.'" type="checkbox" value="1" '.$checked.' />';
    echo '</label>';
  }
}