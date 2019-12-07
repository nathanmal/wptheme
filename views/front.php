<!-- Main navigation -->
<header id="header" class="header-fixed" role="navigation">
  <?php WPTheme\Theme::partial('navbar', array('fixed') ); ?>
  <?php WPTheme\Theme::partial('dropmenu'); ?>
</header>
<!-- Front Template Content -->
<main id="page" role="main">
  <!-- Main Article -->
  <article>
    <section id="content">
      <?php wpt_partial('wptheme'); ?>
    </section>
  </article>
  <!-- End Main Article -->
</main>
<!-- End Main Page Content -->
