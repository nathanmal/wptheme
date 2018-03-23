<header class="header" role="banner">

	<nav class="navbar navbar-expand-lg fixed-top" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">

		<div class="container-fluid">

		<a class="navbar-brand" href="<?=get_site_url()?>/">
			<?php bloginfo('name'); ?>
		</a>

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

</header>