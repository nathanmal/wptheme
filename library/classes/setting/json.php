<?php 

namespace WPTheme\Setting;

use WPTheme\Setting;

class Json extends Setting
{
  public function render_content()
  {
    $value = stripslashes( $this->value );
    $id = $this->input_id();
    $name = $this->input_name();
    echo '<textarea class="widefat" rows="12">' . $value .'</textarea>';
    echo '<input type="hidden" id="'.$id.'" name="'.$name.'" value=\'' . $value .'\' />';
  
  }
}