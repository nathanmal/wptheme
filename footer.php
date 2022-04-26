</main>
<!-- End main page element -->

<!-- Begin Footer -->
<footer id="footer">
  <div class="footer-container container">
    <div class="row">
      <div class="col-lg-12">
        <?php wpt_copyright(); ?>
      </div>
    </div>
  </div>
</footer>
<!-- End Footer -->

<!-- Background -->
<?php wpt_partial( 'background' ); ?>

<!-- Body close -->
<?php do_action( 'wpt_body_close' ); ?>

<!-- Footer Scripts -->
<?php wp_footer(); ?>

<!-- End body tag -->
</body>
<!-- End HTML -->
</html>