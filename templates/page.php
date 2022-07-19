<?php
/**
 * The page template
 *
 * This is the base template for all pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WPTheme
 */

get_header();

?>

  <div id="page" class="<?= wpt_page_container_class() ?>">

    <?php 

    wpt_partial('global/content'); 

    ?>

  </div>

<?php get_footer(); ?>