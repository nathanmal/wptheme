<?php
// Get page/post ID
$id  = get_the_ID();
// Try to get featured image first
$img = get_the_post_thumbnail_url($id,'full');
// Set to default image if empty
if( empty($img) ) $img = Theme::asset('images/banners/default.jpg');
?>
<!-- Begin page banner -->
<div class="banner" role="banner">
    <!-- Content Layer -->
    <div class="content"></div>
    <!-- Image Overlay Layer -->
    <div class="overlay"></div>
    <!-- Image Layer -->
    <div class="image" style="background-image:url('<?=$img?>');"></div>
</div>
<!-- End page banner -->