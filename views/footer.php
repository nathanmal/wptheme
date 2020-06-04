<!-- Global Footer -->
<footer id="footer" class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <p class="copyright">All content and media copyright &copy; <?php echo bloginfo('name') . ' ' . date('Y'); ?></p>
    </div>
  </div>
</footer>

<!-- Page Background -->
<div id="background" style="background-image:url('<?= WPTheme\Theme::background() ?>');"></div>

<!-- Footer Scripts -->
<?php wp_footer(); ?>
