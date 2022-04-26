<?php

global $wp_query;

$term = get_search_query();

$type = $wp_query->query['post_type'] ?? '';

$count = $wp_query->found_posts;
?>
<div class="search-header">
  Found <?= $count ?> 


</div>

