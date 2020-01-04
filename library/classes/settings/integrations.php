<?php 

namespace WPTheme\Settings;

use WPTheme\Settings;

class Integrations extends Settings
{

  public function add_meta_boxes()
  {
    add_meta_box(
        'wpt-google-maps',                       /* Meta Box ID */
        'Google Maps',                   /* Title */
        array($this,'metabox_maps'),  /* Function Callback */
        Settings::$screen,                    /* Screen: Our Settings Page */
        'normal',                             /* Context */
        'high'                                /* Priority */
    );


    add_meta_box(
        'wpt-google-analytics',                       /* Meta Box ID */
        'Google Analytics',                   /* Title */
        array($this,'metabox_analytics'),  /* Function Callback */
        Settings::$screen,                    /* Screen: Our Settings Page */
        'normal',                             /* Context */
        'high'                                /* Priority */
    );
  }

  public function metabox_maps()
  {
    $config = array(
      'note' => 'Enter API Key to Enable Google Maps'
    );

    $this->do_setting( 'maps.google.apikey','text','Google Maps API Key', $config);

    $key = Settings::get('maps.google.apikey');

    if( ! empty($key) )
    {
      $config = array('note'=>'Set the default map center');

      $this->do_setting('maps.center','latlong','Map Center', $config);

      $config = array('note'=>'Set the default map zoom level');

      $this->do_setting('maps.zoom','integer', 'Zoom Level', $config);
    }


    $config = array(
      'note' => 'Enter Snazzymaps API Key to enable style selection'
    );


    $this->do_setting( 'maps.snazzymaps.apikey', 'text', 'Snazzymaps API Key', $config);

    $skey = Settings::get('maps.snazzymaps.apikey', FALSE);

    if( ! empty($skey) )
    {
      $this->do_setting('maps.snazzymaps.style','snazzymaps','Map Style');
    }


  }


  public function metabox_analytics()
  {
    $config = array(
      'placeholder' => 'UA-XXXXXXX-XX'
    );
    $this->do_setting('google.analytics.ua','text','Tracking ID', $config);
  }



  public function render()
  {

    ?> 
     <section id="wpt-google-maps">
      <h1>Google Maps</h1>

      <?php

      $config = array(
        'note' => 'Enter API Key to Enable Google Maps'
      );

      $this->do_setting( 'google.maps.apikey','text','Google Maps API Key', $config);


      $api_key = wpt_setting('google.maps.apikey');

      
      if( ! empty($api_key) )
      {
        $this->do_setting( 'google.maps.center', 'latlong', 'Map Center');

        $this->do_setting( 'snazzymaps.apikey', 'text', 'Snazzy Maps API Key' );


        $config = array(
          'render_input' => array( __CLASS__, 'render_mapstyle_input' )
        );

        $this->do_setting( 'google.maps.style', 'json', 'Map Style', $config );




      }



      

      ?>
    </section>


    <section id="wpt-google-analytics">
      <h1>Google Analytics</h1>
      <?php 
      $this->do_setting( 'gogole.analytics.code','text', 'Google Analytics Code', array('placeholder'=>'UA-XXXXXXX'));
      ?>
    </section>

    <?php 
  }


  public static function render_mapcenter_input( $setting )
  {
    $value = $setting->value;

  }


  public static function render_mapstyle_input( $setting )
  {

    $value = stripslashes( $setting->value );
    $style = json_decode( $value );

    $json = ! empty($style) ? $style->json : '';

    $imageUrl    = $style && isset($style->imageUrl) ? $style->imageUrl : '';
    $name        = $style && isset($style->name) ? $style->name : '';
    $description = $style && isset($style->description) ? $style->description : '';

    $hidden = empty($style) ? 'hidden' : '';

    ?> 

    <div id="wpt-snazzymaps-current" class="<?=$hidden?>">
      <div class="wpt-snazzymaps-current-img" style="background-image:url('<?= $imageUrl ?>');"></div>
      <div class="wpt-snazzymaps-current-detail">
        <h3><?= $name ?></h3>
        <p><?= $description ?></p>
      </div>
    </div>



    <textarea class="widefat" rows="12" id="wpt-snazzymaps-style"><?= $json ?></textarea>
    <input type="hidden" id="wpt-snazzmaps-value" name="<?= $setting->input_name() ?>" value='<?= $value ?>' />
    <button type="button" id="wpt-snazzymaps-select" data-key="<?= wpt_setting('snazzymaps.apikey') ?>">
      Select Map Style
    </button>
    
    

    <?php 

  }
}