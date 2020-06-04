<?php 

namespace WPTheme\Setting;

use WPTheme\Settings;
use WPTheme\Setting;
use WPTheme\Package;

class Packages extends Setting
{

   /**
   * Update the setting to provided value
   *
   * sanitizes/validates value before updating
   *  
   * @param  [type] $value [description]
   * @return [type]        [description]
   */
  public function update( $value = NULL )
  {
    $value = $this->sanitize($value);

    $packages = Setting::get('packages.installed');

    $updated = FALSE;

    foreach($packages as $name => $package)
    {
      if( isset($value[$name]) && is_array($value[$name]) && isset($value[$name]['enqueue']) )
      {
        $packages[$name]['enqueued'] = $value[$name]['enqueue'];
        $updated = TRUE;
        echo 'UPDATED';
      }
    }

    if( $updated )
    {
      return Setting::set('packages.installed', $packages);
    }

    return FALSE;
  }

  public function sanitize( $value )
  {
    return (empty($value) OR ! is_array($value)) ? array() : $value;
  }


  public function render_content()
  {
    $this->render_packages();

    echo '<button class="button button-primary" id="wpt-add-package">Add Package</button>';

    $this->modal_content();

  }


  public function render_packages()
  {
    $packages = Setting::get('packages.installed');

    echo '<ul class="wpt-packages-installed">';

    foreach($packages as $name => $package)
    {
      ?> 
      <li class="wpt-package" data-package="<?= $package['name']?>">
        <div class="wpt-package-details">
          <span class="wpt-package-name"><?= $package['name'] ?></span>
          <span class="wpt-package-version"><?= $package['version'] ?></span>
          <span class="wpt-package-actions">
            <a class="wpt-package-action-enqueue" href="#">Enqueue</a>
            <a class="wpt-package-action-remove" href="<?= Settings::url('assets', array('remove_package'=>$name) )?>">Remove</a>
          </span>
        </div>
        
        <ul class="wpt-package-enqueue">
          <?php 

          foreach($package['enqueued'] as $file => $enqueue)
          {
            $val = $enqueue ? '1' : '0';
            $class = $enqueue ? 'is-enqueued' : '';
            $inputname = $this->input_name() . '[' . $name . '][enqueue]['.$file.']';

            ?> 
            <li class="wpt-package-enqueue-file <?=$class?>" >
              <label><?= $file ?></label>
              <input type="hidden" name="<?=$inputname?>" value="<?=$val?>" />
            </li>

            <?php 
          }
          ?>
        </ul>

      </li>
      <?php
    }

    echo '</ul>';
  }



  public function modal_content()
  {
    ?>

    <div id="wpt-modal-packages" style="display:none">
      <div class="wpt-modal-wrapper wpt-modal-packages">
        <div class="wpt-modal-header">
          <input id="wpt-package-search" type="text" placeholder="Search Packges" />
        </div>
        <div class="wpt-modal-content">
          
        </div>
      </div>    
    </div>



    <?php

  }
}