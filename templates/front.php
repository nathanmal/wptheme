<?php get_header(); ?>


<?php wpt_partial('hero'); ?>

<!-- Main Article -->
<article class="main-article front-article <?= wpt_post_container_class() ?>">
  <?php wpt_partial('page/header'); ?>
  <?php wpt_partial('page/content'); ?>
  <?php wpt_partial('page/footer'); ?>
</article>
<!-- End Main Article -->
<?php get_footer(); ?>