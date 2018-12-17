<?php 
$id = get_the_ID();
?>
<article id="post-<?=$id?>" class="post">
  <header class="post-header">
    <h2><?php the_title(); ?></h2>
  </header>
  <section class="post-content">
    <?php the_content(); ?>
  </section>
  <footer class="post-footer">
    Post footer
  </footer>
</article>