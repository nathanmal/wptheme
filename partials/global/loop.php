<?php
/**
 * 
 * WPTheme loop template
 * 
 *
 *
 *
 * 
 */


?>
<!-- Begin loop -->
<div class="posts">
<?php

if( have_posts() )
{
  while( have_posts() )
  {
    // Set up the post
    the_post();

    ?>
    <article id="post-<?= get_the_ID() ?>" class="post">

      <section class="post-content">
        
        POST CONTENT GOES HERE

      </section>
        

    </article>
    <?php
  }
}
else
{
  ?>
  <div class="no-results">
    <p>Nothing found!</p>
  </div>
  <?php
}



?>
</div>
<!-- End loop -->

<?php
// Reset postdata
wp_reset_postdata();
