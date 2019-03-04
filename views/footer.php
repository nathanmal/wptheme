<!-- Global Site Footer -->

<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <p class="copyright">All content and media copyright &copy; <?= bloginfo('name') . ' ' . date('Y') ?></p>
      <?= THEME_DEBUG ? 'Template: ' . Theme::getTemplate() : '' ?>
    </div>
  </div>
</div>
<!-- WP Footer -->
<?php wp_footer(); ?>
