<?php Theme::partial('navbar'); ?>

<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Webpage">

<div class="container-fluid no-padding" tabindex="-1">

	<div class="row">
	
		<?php 

		if ( have_posts() ) 
		{
			// BEGIN LOOP
			while ( have_posts() ) : the_post();
				$format = get_post_format();

				if( empty($format) ) $format = 'post';

				Theme::view('formats/'.$format);
			endwhile;

		} else {
			// Show missing content message if there are no posts
			Theme::partial('missing'); 
		}

		?>	

	</div> <!-- End .row -->

</div> <!-- End #wrapper -->

</main>