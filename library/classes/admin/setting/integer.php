<?php 

namespace WPTheme\Admin\Setting;

use WPTheme\Admin\Setting;

class Integer extends Setting
{

  /**
   * Validate integer
   * @param  [type] $value [description]
   * @return [type]        [description]
   */
  public function validate( $value )
  {
    if( ! ctype_digit($value) OR ! is_int($value) )
    {
      $this->setError( 'Value must be an integer' );

      return FALSE;
    }

    return TRUE;
  }

  /**
   * Sanitize integer
   * @param  [type] $value [description]
   * @return [type]        [description]
   */
  public function sanitize( $value )
  {
    return intval($value);
  }


  /**
   * Render input
   * @return [type] [description]
   */
  public function render()
  {
    $name = $this->getInputName();
    $id = $this->getInputId();
    echo '<input id="'.$id.'" name="'.$name.'" type="number" min="0" step="1" value="'.$this->value().'" />';
  }
}