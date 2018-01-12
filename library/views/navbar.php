<header class="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

	<nav class="navbar navbar-expand-lg" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
		<div class="container-fluid">
		<a class="navbar-brand" href="<?=get_site_url()?>/">
			<?php bloginfo('name'); ?>
		</a>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	       <span class="navbar-toggler-icon"></span>
	    </button>
		
		<div class="collapse navbar-collapse">
			<?php 
			Theme::menu('main');
			?>
		</div>
		
		
		</div>
	</nav>


</header>