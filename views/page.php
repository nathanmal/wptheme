<!-- Viewport Frame -->
<div id="frame">
  <!-- Main navigation -->
  <header id="header" class="header header-fixed" role="navigation">
    <?php Theme::partial('navbar', array('fixed') ); ?>
    <?php Theme::partial('dropmenu'); ?>
  </header>


  


  <!-- Main Page Content -->
  <main id="page" class="clear-navbar container no-padding" role="main">
    
    <!-- Sidebar -->
    <aside>
      <?php Theme::sidebar(); ?>
    </aside>
    <!-- Main Article -->
    <article>
      <header></header>
      <section id="content">
        <?php Theme::content(); ?>
      </section>
      <footer></footer>
    </article>

    <!-- End Main Article -->
  </main>
  <!-- End Main Page Content -->
  
  <?= get_footer() ?>
</div>
<!-- End Viewport Frame -->