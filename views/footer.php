<!-- Global Footer -->
<footer id="footer" class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <p class="copyright">All content and media copyright &copy; <?php echo bloginfo('name') . ' ' . date('Y'); ?></p>
      <?php echo THEME_DEBUG ? 'Template: ' . WPTheme\Theme::template() : ''; ?>
    </div>
  </div>
</footer>

<?php

if( wpt_setting('assets_use_cdn') ) {
  ?> 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <?php 
} else {
  ?>
  <script src="<?= Theme::asset('package/jquery/jquery-3.4.1/jquery-3.4.1.min.js') ?>"></script>
  <script src="<?= Theme::asset('package/bootstrap/bootstrap-4.3.1/js/bootstrap.min.js') ?>"></script>
  <?php
}

?>

<!-- Footer Scripts -->
<?php wp_footer(); ?>
