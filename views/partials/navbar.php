<?php 

$class = array('navbar','navbar-default','navbar-expand-md');

$fixed   = Theme::setting('theme_navbar_fixed', FALSE);
$hide    = Theme::setting('theme_navbar_hide', FALSE);
$text    = Theme::setting('theme_navbar_text', FALSE);
$bg      = Theme::setting('theme_navbar_background', 'transparent');

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
	       <span class="navbar-toggler-icon"></span>
	  </button>
		
		<div id="navbarCollapse" class="collapse navbar-collapse">
			<?php Theme::menu('main', array('menu_class'=>'nav navbar-nav ml-auto')); ?>
		</div>
    
	</div>
</nav>