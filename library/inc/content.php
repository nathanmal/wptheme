<?php


/**
 * Echo the page/post content
 * @return [type] [description]
 */
function wpt_content()
{
  the_content();
}



function wpt_header()
{
	wpt_partial('header');
}


function wpt_header_class()
{
	return apply_filters('wpt_header_class', 'wpt-header');
}

function wpt_header_menu_class()
{
	return apply_filters('wpt_header_menu_class', 'wpt-header-menu');
}

function wpt_header_menu_location()
{
	return apply_filters('wpt_header_menu_location', 'main');
}

/**
 * Render a navigation menu
 * @param  string $name [description]
 * @param  array  $args [description]
 * @return [type]       [description]
 */
function wpt_menu( string $name, array $args = [] )
{
  wpt()->menu->render($name, $args);
}


/**
 * Get the page container class
 * @return [type] [description]
 */
function wpt_page_container_class()
{
	return apply_filters('wpt_page_container_class', 'container');
}

/**
 * Output the page header
 * @return [type] [description]
 */
function wpt_page_header()
{
	wpt_partial('page/header');
}

/**
 * Output page content
 * @return [type] [description]
 */
function wpt_page_content()
{
	wpt_partial('page/content');
}

/**
 * Output page footer
 * @return [type] [description]
 */
function wpt_page_footer()
{
	wpt_partial('page/footer');
}




function wpt_content_header()
{
  echo '<h1>' . the_title() . '</h1>';
}


function wpt_content_body()
{
  the_content();
}


function wpt_content_footer()
{
  echo '';
}





/**
 * Display the branding in the main navbar
 * @return [type] [description]
 */
function wpt_brand()
{
  echo bloginfo('title');
}




/**
 * Write the page title
 * @return [type] [description]
 */
function wpt_title()
{
  $title = get_bloginfo('name');

  if( is_front_page() )
  {
    $title .= ' | ' . get_bloginfo('description');
  }
  else
  {
    $title .= wp_title('|', FALSE);
  }

  echo '<title>' . $title . '</title>';
}




/**
 * Display site copyright
 * @return [type] [description]
 */
function wpt_copyright()
{
  echo '<p class="copyright">All content and media copyright &copy; '.get_bloginfo('name').' '.date('Y').'</p>';
}



/**
 * Output an attribute string
 * @param  array  $attr [description]
 * @return [type]       [description]
 */
function wpt_attr( array $attr )
{
  $str = '';

  foreach($attr as $name => $value)
  {
    if( is_int($name) )
    {
      $str .= ' ' . $value;
    }
    else
    {
      $str .= ' ' . $name . '="' . esc_attr($value) . '"';
    }
  }

  return $str;
}


/**
 * Output a sidebar
 * @param  string $name [description]
 * @return [type]       [description]
 */
function wpt_sidebar( $name = 'main' )
{
  if( is_active_sidebar($name) )
  {
    dynamic_sidebar($name);
  }
}




/**
 * Output a dropdown
 * @param  string $name    [description]
 * @param  array  $options [description]
 * @param  [type] $value   [description]
 * @param  array  $attr    [description]
 * @return [type]          [description]
 */
function wpt_dropdown( string $name, array $options = array(), $value = NULL, array $attr = array() )
{

  $class = $attr['class'] ?? '';

  echo '<select class="wpt-select2 ' . $class . '">';

  foreach( $options as $val => $label )
  {
    $selected = is_array($value) ? in_array($val, $value) : $val == $value;

    echo '<option value="' . $val . '" ' . ($selected) ? 'selected' : '' . '>' . $label . '</option>';
  }

  echo '</select>'; 
}


/**
 * Output a category dropdown
 * @param  string $taxonomy  [description]
 * @param  string $current   [description]
 * @param  string $post_type [description]
 * @return [type]            [description]
 */
function wpt_category_dropdown( string $taxonomy = 'category', string $current = '', $post_type = 'post' )
{
  $categories = get_categories(['taxonomy'=>$taxonomy]);

  $current = ! empty($current) ? get_term_by('slug', $current, $taxonomy) : FALSE;

  $labels = get_taxonomy_labels(get_taxonomy($taxonomy));

  ?>
  <div class="dropdown wpt-category-dropdown d-grid">

    <button class="btn dropdown-toggle d-lg-block" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      <?= $current ? $current->name : $labels->all_items ?>
    </button>

    <ul class="dropdown-menu" aria-labelledby="category-dropdown">

      <li><a href="<?= get_post_type_archive_link($post_type) ?>"><?= $labels->all_items ?></a></li>

      <?php
      foreach($categories as $category)
      {
        $active = $current && $current->slug == $category->slug ? 'active' : '';
        $count = '(' . $category->category_count . ')';
        ?>
        <li class="<?= $active ?>">
          <a href="<?= get_term_link($category) ?>"><?= $category->name ?> <?= $count ?></a>
        </li>
        <?php
      }
      ?>


    </ul>
  </div>
  <?php

}
