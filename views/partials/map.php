<?php
$id     = 'map';
$key    = wpt_setting('google_maps_key');
$center = wpt_setting('google_maps_center');
$style  = wpt_setting('google_maps_style');

$lat = '';
$lng = '';

$src = 'https://maps.googleapis.com/maps/api/js?key='.$key;
$src .= '&callback=theme.initMap';

if( ! empty($key) )
{
  wp_enqueue_script( 'google-maps', $src, array('wptheme'), NULL, TRUE );
}

if( ! empty($center) && FALSE !== strpos($center, ',') )
{
  list($lat,$lng) = explode(',', $center);
}

$zoom = isset($zoom) ? intval($zoom) : 14;


?> 
<div id="<?=$id?>" class="wpt-map" data-map-zoom="<?=$zoom?>" data-map-lat="<?=$lat?>" data-map-lng="<?=$lng?>" data-map-style='<?=stripslashes($style)?>'>
<?php if( empty($key) ) { ?>
    <div class="map-error">Google API Key Missing</div>
<?php } ?>
</div>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=<?=$key?>&callback=initMap" async defer></script> -->