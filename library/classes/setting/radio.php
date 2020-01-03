<?php 

namespace WPTheme\Setting;

use WPTheme\Setting;

class Radio extends Setting
{
  

  public function render_content()
  {
    if( empty($this->choices) )
    {
      echo '[Choices not specified]';
      return;
    }

    foreach( $this->choices as $value => $label )
    {
      $id = $this->input_id() . '-' . $value;
      $checked = $value == $this->value ? 'checked' : '';
      echo '<label for="' . $id .'">' . $label;
      echo '<input type="radio" id="'.$id.'" name="'.$this->input_name().'" value="'.$value.'" '.$checked.'/>';
      echo '</label>';
    } 
  }
}