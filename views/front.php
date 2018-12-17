


<!-- Viewport Frame -->
<div id="frame">
  
  <!-- Main navigation -->
  <header id="header" class="header-fixed" role="navigation">
    <?php Theme::partial('navbar', array('transparent','text-light')); ?>
    <?php Theme::partial('dropmenu'); ?>
  </header>

  
  <?php 

    Theme::partial( 'banner', array(
      'full',
      'image'=> Theme::asset('images/banners/default.jpg'),
      'content' => '<h1>Front banner content</h1><p>Some subtext for the front banner</p>',
      'overlay' => 50
    ));

  ?>

  <!-- Main Content -->
  <main id="page" role="main" class="container no-padding">
    
    <!-- Sidebar -->
    <aside>
      <?php // Theme::sidebar(); ?>
    </aside>
    <!-- Main Article -->
    <article>
      <header></header>
      <section id="content">
        <?php Theme::content(); ?>
      </section>
      <footer></footer>
    </article>
    
  </main>


  <?= get_footer() ?>
  
</div>