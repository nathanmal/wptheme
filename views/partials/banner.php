<?php
// Get page/post ID and banner image
$id      = get_the_ID();
$thumb   = get_the_post_thumbnail_url($id,'full');

// Check for image or video, fallback to current post thumbnail
$video   = element($data, 'video', FALSE);
$image   = element($data, 'image', $thumb);

// Overlay opacity 0-100
$overlay = 0;

$class   = array('banner');

if( array_contains($data, 'full') )    $class[] = 'banner-full';
if( array_contains($data, 'class') )   $class[] = classes($data['class']);
if( array_contains($data, 'overlay') ) $overlay = intval($data['overlay']) / 100;

$container = array_contains($data, 'wide') ? 'container-fluid' : 'container';

?>
<!-- Begin page banner -->
<div class="<?=classes($class)?>" role="banner">
    <!-- Content Layer -->
    <div class="content">
      <div class="<?=$container?>">
        <?= element($data, 'content', '') ?>
      </div>
    </div>
    <!-- Image Overlay Layer -->
    <div class="overlay" style="background-color:rgba(0,0,0,<?=$overlay?>);"></div>
    <!-- Video Layer -->
    <?php if( $video ) { ?>
    <div class="video">
      <?= html_video( $video, array('class'=>'banner-video','autoplay','loop','muted','preload') ) ?>
    </div>
    <?php } ?>
    <!-- Image Layer -->
    <div class="image" style="background-image:url('<?=$image?>');"></div>
</div>
<!-- End page banner -->