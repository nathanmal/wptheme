<?php
$id     = 'map';
$key    = wpt_setting('google.maps.apikey');
$center = wpt_setting('google.maps.center');
$style  = json_decode(stripslashes(wpt_setting('google.maps.style', '')));
$zoom   = wpt_setting('google.maps.zoom', 14);

$json = $style && isset($style->json) ? $style->json : '';

$lat = '';
$lng = '';

$src = 'https://maps.googleapis.com/maps/api/js?key='.$key;
$src .= '&callback=theme.gmaps.init';

if( ! empty($key) )
{
  wp_enqueue_script( 'google-maps', $src, array('wptheme'), NULL, TRUE );
}

if( ! empty($center) && FALSE !== strpos($center, ',') )
{
  list($lat,$lng) = explode(',', $center);
}

pre($center);
pre($zoom);
pre($style);

?> 
<div id="<?=$id?>" class="wpt-map" data-map-zoom="<?=$zoom?>" data-map-lat="<?=$lat?>" data-map-lng="<?=$lng?>" data-map-style='<?=$json?>'>
<?php if( empty($key) ) { ?>
    <div class="map-error">Google API Key Missing</div>
<?php } ?>
</div>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=<?=$key?>&callback=initMap" async defer></script> -->