<?php
// Get page/post ID
$id  = get_the_ID();
// Try to get featured image first
$img = get_the_post_thumbnail_url($id,'full');
// Set to default image if empty
if( empty($img) ) $img = Theme::asset('images/banners/default.jpg');

?>

<div class="banner" role="banner" style="background-image:url('<?=$img?>');">
    <div class="content">asdfaadsfs</div>
    <div class="overlay"></div>
</div>