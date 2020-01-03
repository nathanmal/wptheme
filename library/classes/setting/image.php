<?php 

namespace WPTheme\Setting;

use WPTheme\Setting;

class Image extends Setting
{
  
  public function render_content()
  {
    wp_enqueue_media();
    $id = $this->input_id();
    $name = $this->input_name();
    ?>
      <div class="wpt-setting-image-wrapper">
        <a href="#" class="wpt-setting-image-upload">
          <span class="dashicons dashicons-format-image"></span>
        </a>
        <a href="#" class="wpt-setting-image-delete">
          <span class="dashicons dashicons-trash"></span>
        </a>
      </div>
      <input type="hidden" id="<?=$id ?>" name="<?=$name?>" value="">

    <?php
  }
}