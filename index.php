<?php 


get_header(); 


if( have_posts() ) {

  while( have_posts() )
  {
    the_post();
    wpt_partial('post/post');
  }
  
}
else
{
  ?>
  <!-- Main Article -->
  <article id="post-<?= get_the_ID() ?>" class="post-article container">
      <section class="post-content">
        <p>There's nothing here!</p>
      </section>
  </article>
  <!-- End Main Article -->
  <?php
}



get_footer();