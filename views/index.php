<!-- Main navigation -->
<header id="header" class="<?= Theme::classes('header') ?>" role="navigation">
	<?php Theme::partial('navbar', array('fixed') ); ?>
	<?php Theme::partial('dropmenu'); ?>
</header>

<!-- Main Page Content -->
<main id="page" class="<?= Theme::classes('page'); ?>" role="main">
	<!-- Sidebar -->
	<?php if( Theme::option('display_sidebar') ) { ?>
	<aside>
		<?php Theme::sidebar(); ?>
	</aside>
	<?php } ?>
	<!-- Main Article -->
	<article>
		<header></header>
		<section id="content">
			<?php Theme::content(); ?>
		</section>
		<footer></footer>
	</article>
	<!-- End Main Article -->
</main>
<!-- End Main Page Content -->

<!-- Begin Footer -->
<footer id="footer">
	<?= get_footer() ?>
</footer>
<!-- End Footer -->
</body>
</html>
