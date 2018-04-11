<header class="header">

	<nav class="navbar navbar-expand-lg fixed-top hide" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">

		<div class="container-fluid">

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	       <span class="navbar-toggler-icon"></span>
	  </button>
		
		<div class="collapse navbar-collapse">
			<?php 
			Theme::menu('main', array('menu_class'=>'navbar-nav mx-auto'));
			?>
		</div>
		
		</div>
	</nav>


	<div class="page-header">
			<div class="container no-padding">
					<div class="page-nav">
							<button class="btn btn-inverse">
								<?php the_title();?> <i class="fas fa-chevron-circle-down"></i>
							</button>
							<?php Theme::menu('main', array('menu_class'=>'nav'));?>
					</div>
			</div>
	</div>


	<div id="drop-menu">
			<?php Theme::menu('main', array('menu_class'=>'nav'));?>
			<a href="#" class="close"><i class="fas fa-times-circle"></i></a>
	</div>


</header>