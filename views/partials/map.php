<?php
$id     = 'map';
$key    = wpt_setting('maps.google.apikey');
$center = wpt_setting('maps.center', array());
$zoom   = wpt_setting('maps.zoom', 14);
$style  = json_decode(stripslashes(wpt_setting('maps.snazzymaps.style', '')));
$json = $style && isset($style->json) ? $style->json : '';

$lat = element($center, 'lat', '');
$lng = element($center, 'lng', '');

$src = 'https://maps.googleapis.com/maps/api/js?key='.$key;
$src .= '&callback=theme.gmaps.init';

if( ! empty($key) )
{
  wp_enqueue_script( 'google-maps', $src, array('wptheme'), NULL, TRUE );
}

?> 
<div id="<?=$id?>" class="wpt-map" data-map-zoom="<?=$zoom?>" data-map-lat="<?=$lat?>" data-map-lng="<?=$lng?>" data-map-style='<?=$json?>'>
<?php if( empty($key) ) { ?>
    <div class="map-error">Google API Key Missing</div>
<?php } ?>
</div>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=<?=$key?>&callback=initMap" async defer></script> -->