<?php 

namespace WPTheme\Setting;

use WPTheme\Setting;
use WPTheme\Settings;

class Googlemaps extends Setting
{

  public function update( $value = NULL )
  {
   
  }


  public function sanitize( $value )
  {
    
  }


  public function render_content()
  {

    $this->render_map();

    echo '<button class="button button-primary" id="wpt-add-googlemaps" type="button">Select Style</button>';

    $this->modal_content();
  }


  public function render_map()
  {

  }



  public function modal_content()
  {
    ?> 
    
    <!-- Snazzy Map Selection Modal -->
    <div id="wpt-modal-googlemaps" style="display:none;">
      <div class="wpt-modal-wrapper wpt-modal-googlemaps">
        <div class="wpt-modal-header">
          <input id="wpt-googlemaps-search" type="text" placeholder="Search Styles" />
          <select id="wpt-googlemaps-sort">
            <option value="">None</option>
            <option value="name">Name</option>
            <option value="relevance">Relevance</option>
            <option value="popular">Popularity</option>
            <option value="recent">Recent</option>
          </select>
          <select id="wpt-googlemaps-tag">
            <option value="">None</option>
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
          <select id="wpt-googlemaps-color">
            <option value="">None</option>
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