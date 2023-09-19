<!-- Begin Page Header -->
<header id="header" class="<?= wpt_header_class() ?>">
    
    <!-- Navbar container -->
    <div class="navbar-container container">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg" role="navigation">

            <!-- Site Branding -->
            <div class="navbar-brand">
              <a href="<?= home_url() ?>">
                <?php bloginfo('title') ?>
              </a>
            </div>
                    
            <!-- Main Navigation Menu -->
            <div id="navbar-menu">
              <?php wpt_menu('header', array('menu_class'=>'nav navbar-nav ms-auto')); ?>
            </div>
            <!-- End navbar menu -->
        
            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
               <span><i class="fas fa-bars navbar-icon-open"></i></span>
               <span><i class="fas fa-times navbar-icon-close"></i></span>
            </button>
        
        </nav>
        <!-- End Navbar -->

    </div>
    <!-- End Navbar container -->

</header>
<!-- End Page Header -->