<?php 

namespace WPTheme\Admin\Setting;

use WPTheme\Admin\Setting;

class Latlong extends Setting
{
  public function render()
  {
    $value = $this->value ?: array();
    $lat = element($value, 'lat', '');
    $lng = element($value, 'lng', '');
    echo '<input type="text" name="'.$this->input_name().'[lat]" value="'.$lat.'" placeholder="Latitude"/>';
    echo '<input type="text" name="'.$this->input_name().'[lng]" value="'.$lng.'" placeholder="Longitude"/>';
  }
}