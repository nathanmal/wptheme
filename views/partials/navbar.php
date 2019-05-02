<?php 

$class = array('navbar','navbar-default','navbar-expand-md');

$fixed   = Theme::mod('navbar_fixed', FALSE);
$hide    = Theme::mod('navbar_hide', FALSE);
$text    = Theme::mod('navbar_text', FALSE);
$bg      = Theme::mod('navbar_background', 'transparent');

if($fixed) $class[] = 'fixed-top';
if($hide)  $class[] = 'navbar-hidden';
if($text)  $class[] = 'navbar-text-' . $text;
if($bg)    $class[] = 'navbar-' . $bg;

$container = array_contains($data, 'wide') ? 'container-fluid' : 'container';

?>

<!-- Navbar -->
<nav class="<?=classes($class)?>" role="navigation">
	<div class="<?=$container?>">
    
    <div class="navbar-brand">
      <a href="<?= bloginfo('url') ?>"><?= bloginfo('title') ?></a>
    </div>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
	       <i class="fas fa-bars"></i>
	  </button>
		
		<div id="navbarCollapse" class="collapse navbar-collapse">
			<?php Theme::menu('main', array('menu_class'=>'nav navbar-nav ml-auto')); ?>
		</div>
    
	</div>
</nav>