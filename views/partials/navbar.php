<?php 


$class .= array_contains($data, 'fixed') ? ' fixed-top' : '';
$class .= array_contains($data, 'hidden') ? ' navbar-hidden' : '';
$class .= array_contains($data, 'light') ? ' navbar-light' : '';
$class .= array_contains($data, 'text-light') ? ' navbar-text-light' : '';
$class .= array_contains($data, 'transparent') ? ' navbar-bg-transparent' : '';

$container = array_contains($data, 'wide') ? 'container-fluid' : 'container';

?>

<!-- Navbar -->
<nav class="navbar navbar-default navbar-expand-md <?=$class?>" role="navigation">
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