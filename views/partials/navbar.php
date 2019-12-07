<?php 

$class = array('navbar','navbar-default','navbar-expand-md');

// Is it a fixed navbar?
if( isset($fixed) && $fixed ) 
{
  $class[] = 'fixed-top';
  
  // Does it hide?
  if( isset($hidden) && $hidden ) $class[] = 'navbar-hidden';
}

$container = isset($wide) && $wide ? 'container-fluid' : 'container';

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
			<?php WPTheme\Theme::menu('main', array('menu_class'=>'nav navbar-nav ml-auto')); ?>
		</div>
    
	</div>
</nav>