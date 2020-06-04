<?php 
$preview = isset($preview);
?>


<div class="post">
  <div class="post-header">
    <h3><?= the_title() ?></h3>
  </div>
  <div class="post-content">
    <?= the_content() ?>
  </div>
</div>

