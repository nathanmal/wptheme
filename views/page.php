<!-- Main navigation -->
<header id="header" class="header-fixed" role="navigation">
  <?php WPTheme\Theme::partial('navbar', array('fixed') ); ?>
  <?php WPTheme\Theme::partial('dropmenu'); ?>
</header>
<!-- Page Template Content -->
<main id="page" role="main">
  <!-- Main Article -->
  <div class="container">
    <article>
      <section id="content">
        <?php wpt_partial('wptheme'); ?>
      </section>
    </article>
  </div>
  <!-- End Main Article -->
</main>
<!-- End Main Page Content -->

