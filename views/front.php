<!-- Main navigation -->
<header id="header" class="<?= WPTheme\Theme::classes('header') ?>" role="navigation">
  <?php WPTheme\Theme::partial('navbar', array('fixed','hidden') ); ?>
  <?php WPTheme\Theme::partial('dropmenu'); ?>
</header>

<!-- Front Page Content -->
<main id="page" class="<?= WPTheme\Theme::classes('page'); ?>" role="main">
  <!-- Sidebar -->
  <?php if( WPTheme\Theme::option('display_sidebar') ) { ?>
  <aside><?php WPTheme\Theme::sidebar(); ?></aside>
  <?php } ?>
  <!-- Main Article -->
  <article>
    <header><h1>WP Theme</h1></header>
    <section id="content">
      <p>Starter theme for Wordpress</p>
      <a href="#">Settings</a> | 
      <a href="#">Documentation</a>
      <hr/>
      <?php WPTheme\Theme::content(); ?>
    </section>
    <footer></footer>
  </article>
  <!-- End Main Article -->
</main>
<!-- End Main Page Content -->