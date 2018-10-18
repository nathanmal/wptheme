<?php 

Theme::partial('navbar');

if( have_posts() ) the_post(); 
?>

<div class="container-fluid">
    
    <?php Theme::partial('banner'); ?>
    
    <main id="content" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Webpage">
        
      <?php the_content(); ?>

    </main><!-- End main#content -->

</div><!-- End #page.page-wrapper -->
