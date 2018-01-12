<?php Theme::view('navbar'); ?>

<div id="wrapper" class="container-fluid" tabindex="-1">

	<div class="row">

	<main id="main" role="main" itemscope itemprop="mainContentOfPage" itemtype="http://schema.org/Webpage">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-XXX.php (where XXX is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'views/content', get_post_format() );
				?>

			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'loop-templates/content', 'missing' ); ?>

		<?php endif; ?>

	</main>

	</div> <!-- End .row -->

</div> <!-- End #wrapper -->
