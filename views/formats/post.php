<article id="post-<?= get_the_ID() ?>" class="post">
  <header class="post-header">
    <h2><?php the_title(); ?></h2>
  </header>
  <section class="post-content">
    <?php the_content(); ?>
  </section>
  <footer class="post-footer">
    <small>Foot notes</small>
  </footer>
</article>