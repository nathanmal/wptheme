<?php
// Get page/post ID and banner image
$id      = get_the_ID();
$thumb   = get_the_post_thumbnail_url($id,'full');

// Check for image or video, fallback to current post thumbnail
$video   = element($data, 'video', FALSE);
$image   = element($data, 'image', '');
$content = element($data, 'content', '');
$class   = element($data, 'class', '');
$fluid   = !! element($data, 'fluid', FALSE);
$overlay = intval(element($data, 'overlay', 0));


$class   = array('banner');

if( array_contains($data, 'full') )    $class[] = 'banner-full';
if( array_contains($data, 'class') )   $class[] = classes($data['class']);
if( array_contains($data, 'overlay') ) $overlay = intval($data['overlay']) / 100;

$container = array_contains($data, 'wide') ? 'container-fluid' : 'container';

?>
<!-- Begin page banner -->
<div class="banner <?=classes($class)?>" role="banner">

    
    <?php if( ! empty($content) ) { ?>
    <!-- Content Layer -->
    <div class="banner-content">
        <?= $content ?>
    </div>
    <!-- End Content Layer -->
    <?php } ?>
    
    
    <?php if( ! empty($overlay) ) { ?>
    <!-- Background Overlay Layer -->
    <div class="banner-overlay" style="background-color:rgba(0,0,0,<?=round($overlay/100,2)?>);"></div>
    <!-- End Background Overlay Layer -->
    <?php } ?>
    
    <?php if( ! empty($video) ) { ?>
    <!-- Background Video Layer -->
    <div class="banner-video">
    wpt_background_video($video);
    </div>
    <!-- End Background Video Layer -->
    <?php } ?>

    <?php if( ! empty($image) ) { ?>
    <!-- Background Image Layer -->
    <div class="banner-image" style="background-image:url('<?=$image?>');"></div>
    <!-- End Background Image Layer -->
    <?php } ?>
    <!-- Image Layer -->
    
</div>
<!-- End page banner -->