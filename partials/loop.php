<?php
/**
 * WPTheme loop template
 * 
 *
 *
 *
 * 
 */

// args array
$args = $args ?? [];

// item name
$item = $args['item'] ?? '';

// list class name
$class = $args['class'] ?? '';


echo '<div class="entries ' . $class . '">';

if( have_posts() )
{
  while( have_posts() )
  {
    // Set up the post
    the_post();

    // Get item template
    wpt_partial( 'loop/item', $item, $args ); 

  }
}
else
{
  // Display no entries message
  wpt_partial('loop/empty', $item, $args );
}

echo '</div>';