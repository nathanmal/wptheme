<?php 
$id  = get_the_ID();
$img = get_the_post_thumbnail_url($id,'full') || THEME_URI . '/assets/images/default.jpg';
?>

<div class="container-fluid no-padding">
    <div class="banner" style="background:url('<?=$img?>') center center no-repeat;background-size:cover;">
        <a href="<?= site_url('') ?>" class="home-link"><?= get_bloginfo('name') ?></a>
        <div class="gradient"></div>
    </div>
</div>