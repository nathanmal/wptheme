<?php WPTheme\Theme::$footer = FALSE; ?>
<!-- Main Page Content -->
<main id="page" class="<?= classes('page'); ?>" role="main">
  <!-- Sidebar -->
  <?php if( WPTheme\Theme::option('display_sidebar') ) { ?>
  <aside>
    <?php WPTheme\Theme::sidebar(); ?>
  </aside>
  <?php } ?>
  <!-- Main Article -->
  <article>
    <header><h1>Error 404</h1></header>
    <section id="content">
        <p>It appears you've reached this page in error.</p>
        <a href="<?= bloginfo('url') ?>">Return to the home page</a>
    </section>
    <footer></footer>
  </article>
  <!-- End Main Article -->
</main>
<!-- End Main Page Content -->


<!-- End Footer -->
</body>
</html>





