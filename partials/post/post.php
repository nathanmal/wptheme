<!-- Post Article -->
<article id="post-<?= get_the_ID() ?>" class="post-article">
    <?php wpt_partial('post/header'); ?>
    <section class="post-content">
      <div class="container">
        <?php the_content(); ?>
      </div>
    </section>
    <?php wpt_partial('post/footer'); ?>
</article>
<!-- End Post Article -->