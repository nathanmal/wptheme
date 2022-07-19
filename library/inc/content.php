<?php if ( ! defined( 'ABSPATH' ) ) exit('Foolish Mortal'); 


/**
 * Echo the page/post content
 * @return [type] [description]
 */
function wpt_content()
{
  the_content();
}


/**
 * Output the page header
 * @return [type] [description]
 */
function wpt_header()
{
	wpt_partial('header');
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
 * Get slug of a post
 * @param  int $post_id ID of post
 * @return string|false FALSE if post is not a page
 */
function wpt_post_slug( $post_id = NULL )
{
    $post = get_post($post_id);

    return $post ? $post->post_name : FALSE;
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


/**
 * Get post excerpt
 *
 * if the excerpt field isn't used, use a trimmed content field
 * @param  [type] $post   [description]
 * @param  [type] $length [description]
 * @return [type]         [description]
 */
function wpt_excerpt( $post = NULL, $length = NULL)
{
  $post = get_post($post);
  // Use excerpt if it exists
  if( ! empty($post->post_excerpt) ) return $post->post_excerpt;

  // Otherwise generate it from content
  $text = strip_shortcodes( $post->post_content );
  $text = apply_filters( 'the_content', $text );
  $text = str_replace(']]>', ']]&gt;', $text);
  $excerpt_length = intval($length) ?: apply_filters( 'excerpt_length', 55 );
  $excerpt_more = apply_filters( 'excerpt_more', '&nbsp;[&hellip;]' );
  $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
  return $text;
}


/**
 * Output a background video
 * @param  [type] $video  [description]
 * @param  string $poster [description]
 * @return [type]         [description]
 */
function wpt_background_video($video, $poster = '')
{
    echo '<video class="video-background" playsinline loop muted autoplay ';

    if( ! empty($poster) ) 
    {
        echo 'poster="' . $poster .'"';
    }

    echo '>';

    if( is_string($video) )
    {
        $video = array( $video => mime_content_type($video) );
    }

    foreach($video as $src => $type)
    {
        echo '<source src="' . $src . '" type="' . $type .'" />';
    }

    if( ! empty($poster) )
    {
        echo '<img class="video-background-poster" src="' . $poster . '"/>';
    }

    echo '</video>';
}



function wpt_filed_under( $post, $taxonomy = 'category', $limit = 1, $link = TRUE, $target = '_blank' )
{
  $terms = get_the_terms( $post, $taxonomy );

  echo '<div class="filed-under">Filed under';
  wpt_category_list($post,$taxonomy,$limit,$link,$target);
  echo '</div>';

}


function wpt_category_list( $post, $taxonomy = 'category', $limit = 1, $link = TRUE, $target = '_blank', $return = FALSE )
  {
    $terms = get_the_terms( $post, $taxonomy );
    $c = 0;
    $out = '';

    if( ! empty($terms) )
    {
      $out = '<ul class="terms terms-'.$taxonomy.'">';
      foreach($terms as $term)
      {
        if( $c >= $limit ) break;
        $out .= '<li class="term">';
        if( $link ) $out .= '<a href="' . get_term_link($term->term_id) .'" target="' . $target .'">';
        $out .= '<span class="term-name">' . $term->name . '</span>';
        if( $link ) $out .= '</a>';
        $out .= '</li>';
        $c++; 
      }
      $out .= '</ul>';
    }
    

    if( $return ) return $out;

    echo $out;
  }


function wpt_get_category_list( $post, $taxonomy = 'category', $limit = 1, $link = TRUE, $target = '_blank' )
{
  return wpt_category_list( $post, $taxonomy, $limit, $link, $target, TRUE );
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

function wpt_post_container_class( $classes = array() )
{
  return apply_filters('wpt_post_container_class', 'container-fluid');
}

function wpt_navbar_class()
{
  return 'navbar-expand-lg';
}

function wpt_navbar_menu_classes()
{
  return 'collapse navbar-collapse';
}

/**
 * Classes for the header
 * @return [type] [description]
 */
function wpt_header_classes()
{
  $classes = apply_filters( 'wpt_header_classes', array() );

  return implode(' ', array_unique($classes) );
}
