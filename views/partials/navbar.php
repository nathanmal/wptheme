<header class="header">
	<!-- Page Navbar -->
	<nav class="navbar navbar-expand-lg fixed-top hide" role="navigation">
		<div class="container-fluid">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		       <span class="navbar-toggler-icon"></span>
		  </button>
			
			<div class="collapse navbar-collapse">
				<?php Theme::menu('main', array('menu_class'=>'navbar-nav mx-auto')); ?>
			</div>
		</div>
	</nav>
	<!-- Pull-down Menu -->
	<div id="drop-menu">
			<?php Theme::menu('main', array('menu_class'=>'nav'));?>
			<a href="#" class="close"><i class="fas fa-times-circle"></i></a>
	</div>
</header>