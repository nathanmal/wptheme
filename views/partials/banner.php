<?php
// Get page/post ID
$id  = get_the_ID();
// Pass this to override
$banner = isset($banner) ? $banner : array();
// Try to get featured image first
$img = isset($banner['image']) ? $banner['image'] : get_the_post_thumbnail_url($id,'full');
// Set to default image if empty
if( empty($img) ) $img = Theme::asset('images/banners/default.jpg');
?>
<!-- Begin page banner -->
<div class="banner" role="banner">
    <!-- Content Layer -->
    <div class="content"><?= isset($banner['content']) ? $banner['content'] : '' ?></div>
    <!-- Image Overlay Layer -->
    <div class="overlay"></div>
    <!-- Image Layer -->
    <div class="image" style="background-image:url('<?=$img?>');"></div>
</div>
<!-- End page banner -->