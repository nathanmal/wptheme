<?php
// Check for image or video, fallback to current post thumbnail
$video   = element($data, 'video', FALSE);
$image   = element($data, 'image', '');
$content = element($data, 'content', '');
$overlay = intval(element($data, 'overlay', 0));

// Build class array
$classes = array();

foreach( array('fixed','fixed-image','full') as $class )
{
    if( in_array($class, $data) ) $classes[] = 'banner-' . $class;
}

// $container = array_intersect($data, array('fluid','wide')) ? 'container-fluid'

?>
<!-- Begin page banner -->
<div class="banner <?=classes($classes)?>" role="banner">
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
        <?php wpt_background_video($video); ?>
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