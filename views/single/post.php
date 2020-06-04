<?php the_post(); ?>
<!-- Page Template Content -->
<main id="page" role="main" class="clear-header">
  <!-- Main Article -->
  <div class="container">
    <article id="article">
      <?php WPTheme\Theme::sidebar('main'); ?>
      <div id="sections">
        <section id="content">
          <?php wpt_partial('wptheme/intro'); ?>
          <?php wpt_partial('wptheme/post'); ?>
        </section>
      </div>
    </article>
  </div>
  <!-- End Main Article -->
</main>
<!-- End Main Page Content -->

