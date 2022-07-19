<?php 

namespace WPTheme\Admin\Setting;

use WPTheme\Admin\Setting;

class Json extends Setting
{
  public function render()
  {
    $value = stripslashes( $this->value );
    $id = $this->input_id();
    $name = $this->input_name();
    echo '<textarea class="widefat" rows="12">' . $value .'</textarea>';
    echo '<input type="hidden" id="'.$id.'" name="'.$name.'" value=\'' . $value .'\' />';
  
  }
}