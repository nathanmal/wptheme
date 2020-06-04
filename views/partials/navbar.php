<!-- Navbar -->
<nav class="navbar navbar-shy navbar-expand-md" role="navigation">
	<div class="container">
    <!-- Navbar Brand -->
    <div class="navbar-brand">
      <a href="<?= bloginfo('url') ?>"><?= bloginfo('title') ?></a>
    </div>
    <!-- Navbar Toggler (mobile) -->
		<button class="navbar-toggler" type="button">
	     <i class="fas fa-bars"></i><i class="fas fa-times"></i>
	  </button>
		<!-- Navbar Menu -->
		<div id="navbar-menu" class="collapse navbar-collapse">
      <div class="navbar-mobile-header"><h3>Mobile Header</h3></div>
			<?php WPTheme\Theme::menu('main', array('menu_class'=>'nav navbar-nav ml-auto')); ?>
		</div>
	</div>
</nav>
<!-- End Navbar -->