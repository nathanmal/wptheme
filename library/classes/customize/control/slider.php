<?php

namespace WPTheme\Customize\Control;

use WPTheme\Customize\Control;

class Slider extends Control
{


  public $type = 'slider';



  public function render_content()
  {

    $min  = $this->input_attrs['min'] ?? 0;
    $max  = $this->input_attrs['max'] ?? 100;
    $step = $this->input_attrs['step'] ?? 1;


    $unit = $this->input_attrs['unit'] ?? '';

    ?>
    <div class="wpt-customize-control wpt-customize-control-slider">
      <span class="customize-control-title"><?= $this->label ?></span>
      <div class="wpt-customize-control-slider-wrapper">
      <input type="range" <?= $this->link() ?> id="<?= esc_attr( $this->id ) ?>" name="<?= esc_attr( $this->id ) ?>" min="<?= $min ?>" max="<?= $max ?>" step="<?= $step ?>" value="<?= esc_attr( $this->value() ) ?>" data-unit="<?= esc_attr( $unit ) ?>" />
      <span class="wpt-customize-control-slider-value"></span>
      </div>
      
    </div>
    <?php
  }




}