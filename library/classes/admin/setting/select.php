<?php 

namespace WPTheme\Admin\Setting;

use WPTheme\Admin\Setting;

class Select extends Setting
{

  /**
   * Check for valid option
   * @param  [type] $value [description]
   * @return [type]        [description]
   */
  public function validate($value)
  {
    if( ! isset($this->options[$value]) )
    {
      $this->setError('Selection must be a valid option');

      return FALSE;
    }

    return TRUE;
  }


  /**
   * Dont need to sanitize as validation enforces a valid option
   * @param  [type] $value [description]
   * @return [type]        [description]
   */
  public function sanitize($value)
  {
    return $value;
  }


  /**
   * Render the select element
   * @return [type] [description]
   */
  public function render()
  {
    if( empty($this->options) )
    {
      echo '[Choices not specified]';
      return;
    }

    echo '<select id="'.$this->getInputId().'" name="'.$this->getInputName().'">';


    $value = $this->value();


    if( ! $this->required() )
    {
      echo '<option value="" '.(empty($value) ? 'selected' : '').'>Select...</option>';
    }

    foreach($this->options as $key => $label )
    {
      $selected = $key === $value ? 'selected' : '';

      echo '<option value="'.$key.'" '.$selected.'>' . $label .'</option>';
    }

    echo '</select>';
  }
}