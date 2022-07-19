<?php 

namespace WPTheme\Admin\Setting;

use WPTheme\Admin\Setting;

class Text extends Setting
{
  public function sanitize( $value )
  {
    return sanitize_text_field($value);
  }


  public function render()
  {
    $ph   = element($this->config, 'placeholder', '');
    $id   = $this->input_id();
    $name = $this->input_name();

    echo '<input id="'.$id.'" name="'.$name.'" placeholder="'.$ph.'" type="text" value="' . $this->value . '" />';
  }
}