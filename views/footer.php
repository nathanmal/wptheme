<!-- Global Footer -->
<footer id="footer" class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <p class="copyright">All content and media copyright &copy; <?php echo bloginfo('name') . ' ' . date('Y'); ?></p>
      <?php echo THEME_DEBUG ? 'Template: ' . Theme::template() : ''; ?>
    </div>
  </div>
</footer>
<!-- Footer Scripts -->
<?php wp_footer(); ?>
