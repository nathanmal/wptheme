<?php
/**
 * The template for a front page
 *
 * This is the template for displaying a front page, if a static front page is selected in settings
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