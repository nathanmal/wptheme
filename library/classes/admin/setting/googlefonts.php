<?php 

namespace WPTheme\Admin\Setting;

use WPTheme\Admin\Setting;
use WPTheme\Settings;

class Googlefonts extends Setting
{

  public function update( $value = NULL )
  {
    $fonts = Setting::get('fonts.installed', array());

    $updated = FALSE;

    foreach( $value as $family => $variants )
    {
      if( isset($fonts[$family]) )
      {
        $fonts[$family]['enqueue'] = $variants;

        $updated = TRUE;
      }
    }

    if( $updated )
    {
      return Setting::set('fonts.installed', $fonts);
    }

    return TRUE;
  }


  public function sanitize( $value )
  {
    return (empty($value) OR ! is_array($value) ) ? array() : $value;
  }


  public function render()
  {
    
    $this->render_fonts();

    echo '<button class="button button-primary" id="wpt-add-googlefonts" type="button">Add Font</button>';

    $this->modal_content();
  }


  public function render_fonts()
  {
    $fonts = Setting::get('fonts.installed', array());

    ?> 
    <div class="wpt-fonts">
      <?php foreach($fonts as $family => $font)
      {
        $link = Settings::url('assets', array('remove_font'=>$family) );

        ?>
        <div class="wpt-font">
          <div class="wpt-font-details">
            <div class="wpt-font-family"><?=$family?></div>
            <div class="wpt-font-variants">
            <?php 
            
            foreach($font['item']->variants as $variant)
            {
              $name = $this->input_name() . '['.$family.']['.$variant.']';
              $checked = isset($font['enqueue'][$variant]) ? 'checked' : '';
              ?> 
              <label>
                <input type="checkbox" name="<?=$name?>" value="1" <?=$checked?>/>
                <?= $variant ?>
              </label>

              <?php 
            }


            ?>
          </div>
            <a href="<?=$link?>" class="wpt-font-remove">Remove</a>
          </div>
          

        </div>

        <?php


      }
      ?>

    </div>

    <?php 
  }


  public function modal_content()
  {
    ?> 

    <div id="wpt-modal-googlefonts" style="display:none;">
      <div class="wpt-modal-wrapper wpt-modal-googlefonts">
        <div class="wpt-modal-header">
          <input id="wpt-font-search" class="wpt-search" type="text" placeholder="Search Fonts" />
          <input id="wpt-font-sample" type="text" placeholder="Enter Sample Text" />
          <select id="wpt-font-sort">
            <option value="trending">Trending</option>
            <option value="popularity">Popularity</option>
            <option value="date">Date Added</option>
            <option value="style">Style Count</option>
            <option value="alpha">Alphabetically</option>
          </select>
          <div class="wpt-font-categories">
            <label for="font-category-serif"><input type="checkbox" name="font[category][]" id="font-category-serif" value="serif" />Serif</label>
            <label for="font-category-sansserif"><input type="checkbox" name="font[category][]" id="font-category-sansserif" value="sans-serif" />Sans-Serif</label>
            <label for="font-category-display"><input type="checkbox" name="font[category][]" id="font-category-display" value="display" />Display</label>
            <label for="font-category-handwriting"><input type="checkbox" name="font[category][]" id="font-category-handwriting" value="handwriting" />Handwriting</label>
            <label for="font-category-monospace"><input type="checkbox" name="font[category][]" id="font-category-monospace" value="monospace" />Monospace</label>
          </div>
        </div>
        <div class="wpt-modal-content">
          
        </div>
      </div>
    </div>

    <?php 
  }
}