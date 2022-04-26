<?php

namespace WPTheme\Customize\Control;

use WPTheme\Customize\Control;

class Coloralpha extends Control
{

  /**
   * Type description
   * @var string
   */
  public $type = 'color_alpha';


  /**
   * Color palette defaults
   */
  public $defaultPalette = array(
    '#000000',
    '#ffffff',
    '#dd3333',
    '#dd9933',
    '#eeee22',
    '#81d742',
    '#1e73be',
    '#8224e3',
  );

  /**
   * Enqueue alpha color picker
   * @return [type] [description]
   */
  public function enqueue()
  {
    parent::enqueue();

    $script = get_template_directory_uri() . '/assets/js/wp-color-picker-alpha-min.js';

    wp_enqueue_script( 'wp-color-picker' );

    wp_enqueue_script( 'wptheme-customizer-controls-alpha-color', $script, array('wp-color-picker'));

    wp_enqueue_style( 'wp-color-picker' );
  }

  /**
   * Pass our Palette colours to JavaScript
   */
  public function to_json() 
  {
    parent::to_json();

    $this->json['colorpickerpalette'] = $this->input_attrs['palette'] ?? $this->defaultPalette;

  }

  public function render_content()
  { 

    $resetalpha = $this->input_attr['resetalpha'] ?? 'true';

    $attributes  = 'data-default-color="' . esc_attr( $this->value() ) . '"';
    $attributes .= 'data-alpha="true"';
    $attributes .= 'data-reset-alpha="' . $resetalpha . '"';
    $attributes .= 'data-custom-width="0"';


    ?>
    <div class="wpt-customize-control wpt-customize-control-color-alpha">

      <?php if( !empty( $this->label ) ) { ?>
          <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
      <?php } ?>

      <?php if( !empty( $this->description ) ) { ?>
          <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
      <?php } ?>

      <input type="text" class="wpcolorpicker-alpha-color-picker wpt-customize-alpha-color-picker customize-control-colorpicker-color-alpha" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" <?= $attributes ?> <?php $this->link(); ?> />
      
    </div>
    <?php
  }




}