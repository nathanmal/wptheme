<?php
/**
 * The index template
 *
 * This is the base template for the site
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WPTheme
 */

get_header();

?>
  
  <div id="page" class="<?= wpt_page_container_class() ?>">
    
    <?php

    wpt_partial('global/loop');

    ?>

  </div>

<?php

get_footer();