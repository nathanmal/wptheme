<?php 

namespace WPTheme\Admin\Setting;

use WPTheme\Admin\Setting;
use WPTheme\Settings;

class Snazzymaps extends Setting
{

  

  public function sanitize( $value )
  {
    return $value;
  }


  public function render()
  {

    $this->render_map();

    echo '<button class="button button-primary" id="wpt-add-snazzymaps" type="button">Select Style</button>';

    $this->modal_content();
  }


  public function render_map()
  {
    $value = stripslashes( $this->value );

    $style = json_decode( $value );

    $imageUrl    = $style && isset($style->imageUrl) ? $style->imageUrl : '';
    $stylename   = $style && isset($style->name) ? $style->name : '';
    $description = $style && isset($style->description) ? $style->description : '';

    $hidden = empty($style) ? 'hidden' : '';

    $name = $this->input_name();
    $id = $this->input_id();

    ?> 

    <div id="wpt-snazzymaps-current" class="<?=$hidden?>">
      <div class="wpt-snazzymaps-current-img" style="background-image:url('<?= $imageUrl ?>');"></div>
      <div class="wpt-snazzymaps-current-detail">
        <h3><?= $stylename ?></h3>
        <p><?= $description ?></p>
      </div>
    </div>


<!--     <textarea class="widefat" rows="12" id="wpt-snazzymaps-style"><?= $json ?></textarea>
 -->    <input type="hidden" id="<?=$id?>" name="<?= $name ?>" value='<?= $value ?>' />

    <?php

  }



  public function modal_content()
  {
    ?> 
    
    <!-- Snazzy Map Selection Modal -->
    <div id="wpt-modal-snazzymaps" style="display:none;">
      <div class="wpt-modal-wrapper wpt-modal-snazzymaps">
        <div class="wpt-modal-header">
          <input id="wpt-snazzymaps-search" type="text" placeholder="Search Styles" />
          <select id="wpt-snazzymaps-sort">
            <option value="">Sort By</option>
            <option value="name">Name</option>
            <option value="relevance">Relevance</option>
            <option value="popular">Popularity</option>
            <option value="recent">Recent</option>
          </select>
          <select id="wpt-snazzymaps-tag">
            <option value="">Select Tag</option>
            <option value="colorful">Colorful</option>
            <option value="complex">Complex</option>
            <option value="dark">Dark</option>
            <option value="grayscale">Grayscale</option>
            <option value="light">Light</option>
            <option value="monochrome">Monochrome</option>
            <option value="no-labels">No Labels</option>
            <option value="simple">Simple</option>
            <option value="two-tone">Two Tone</option>
          </select>
          <select id="wpt-snazzymaps-color">
            <option value="">Select Color</option>
            <option value="black">Black</option>
            <option value="blue">Blue</option>
            <option value="gray">Gray</option>
            <option value="green">Green</option>
            <option value="multi">Multicolor</option>
            <option value="orange">Orange</option>
            <option value="purple">Purple</option>
            <option value="red">Red</option>
            <option value="white">White</option>
            <option value="yellow">Yellow</option>
          </select>
        </div>
        <div class="wpt-modal-content"></div>
      </div>
    </div>


    <?php 
  }
}