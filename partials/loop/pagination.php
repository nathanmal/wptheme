<?php
global $wp_query;

if( $wp_query && $wp_query->max_num_pages > 1 )
{
  ?>
  <div class="pagination">
    <?= paginate_links() ?>
  </div>
  <?php
}
?>