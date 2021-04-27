</main>
<!-- End main page element -->

<!-- Begin Footer -->
<footer id="footer">
  <div class="footer-container container">
    <div class="row">
      <div class="col-lg-12">
        <?php wpt_copyright(); ?>
        <br/>

        <?php echo get_page_template(); ?>
      </div>
    </div>
  </div>
</footer>
<!-- End Footer -->

<!-- Page Background -->
<div id="background"></div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

<!-- Footer Scripts -->
<?php wp_footer(); ?>
<!-- End Body -->
</body>
<!-- End HTML -->
</html>