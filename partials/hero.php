<?php
$image = isset($args['image']) ? wp_get_attachment_url($args['image']) : '';
$content = $args['content'] ?? '';
$height = isset($args['height']) ? 'height:'. $args['height'] : '';
?>


<div class="hero" style="<?=$height?>">
  <div class="hero-content container"><?= $content ?></div>
  <div class="hero-overlay"></div>
  <div class="hero-background" style="background-image:url(<?= $image ?>);" ></div>
</div>