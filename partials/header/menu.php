<!-- Navbar Menu -->
<div id="navbar-menu" class="<?= wpt_navbar_menu_classes() ?>">
  <?php 

  $location = apply_filters( 'wpt_main_menu_location', 'main' );

  wpt_menu($location, array('menu_class'=>'nav navbar-nav ms-auto')); 

  ?>
</div>