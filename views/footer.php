<!-- Global Site Footer -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <p class="copyright">All content and media copyright &copy; <?= bloginfo('name') . ' ' . date('Y') ?></p>
        <?= THEME_DEBUG ? Theme::getTemplate() : '' ?>
      </div>
    </div>
  </div>
</footer>
<!-- WP Footer -->
<?php wp_footer(); ?>
</body>
</html>