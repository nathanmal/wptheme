<?php 

namespace WPTheme\Setting;

use WPTheme\Setting;

class Select extends Setting
{
  public function render_content()
  {
    if( empty($this->config['choices']) )
    {
      echo '[Choices not specified]';
      return;
    }

    $id = $this->input_id();
    $name = $this->input_name();
    $allow_null = element($this->config, 'allow_null', TRUE);

    echo '<select id="'.$id.'" name="'.$name.'">';

    if( $allow_null )
    {

      echo '<option value="" '.(empty($this->value) ? 'selected' : '').'>Select...</option>';
    }

    foreach($this->choices as $value => $label )
    {
      $selected = $value === $this->value ? 'selected' : '';

      echo '<option value="'.$value.'" '.$selected.'>' . $label .'</option>';
    }

    echo '</select>';
  }
}