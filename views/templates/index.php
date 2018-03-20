<?php Theme::partial('navbar'); ?>

<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Webpage">
	<div class="container-fluid no-padding" tabindex="-1">
		<div class="row">
			<!-- Begin Loop -->
			<?php 

			if ( have_posts() ) 
			{
				while ( have_posts() ) : the_post();
					// Check post format
					$format = get_post_format();
					// If not used, default with post
					if( empty($format) ) $format = 'post';
					// Include format view
					Theme::view('formats/'.$format);
				endwhile;

			} else {
				// Show missing content message if there are no posts
				Theme::partial('missing'); 
			}

			?>	
			<!-- End Loop -->
		</div>
	</div>
</main>