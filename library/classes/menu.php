<?php

namespace WPTheme;

use \Walker_Nav_Menu;

class Menu extends Walker_Nav_Menu
{
  /**
   * Class constructor
   */
  public function __construct()
  {
    add_filter('nav_menu_css_class', array($this, 'menu_css_class'), 10, 4 );

    add_filter('nav_menu_link_attributes', array($this, 'link_attributes'), 10, 4);

    $this->register();
  }


  /**
   * Register menus
   * @return [type] [description]
   */
  protected function register()
  {
    $menus = apply_filters( 'wpt_menus',array(
      'header'  => __( 'Header Menu',  WPT_DOMAIN ), 
      'mobile'  => __( 'Mobile Menu',  WPT_DOMAIN ), 
      'members' => __( 'Members Menu', WPT_DOMAIN ),   
      'footer'  => __( 'Footer Menu',  WPT_DOMAIN ),
      'links'   => __( 'Links Menu',   WPT_DOMAIN ),
      'social'  => __( 'Social Menu',  WPT_DOMAIN )
    ));

    foreach($menus as $menu => $description)
    {
      register_nav_menu($menu, __($description, WPT_DOMAIN));
    }
  }


  /**
   * Render a menu
   * @see    https://developer.wordpress.org/reference/functions/wp_nav_menu/ 
   * @param  string $location   [description]
   * @param  array  $config Allow function to override default menu array
   * @return [type]         [description]
   */
  public function render( string $location, array $config = array() )
  {

    if( ! has_nav_menu($location) ) 
    {
      echo '[Could not locate menu ' . $location .']';
      return;
    }

    $menu = array(
      'theme_location'  => $location,              
      'container'       => '',                              
      'container_class' => 'nav-container',                  
      'menu_class'      => 'nav-wrapper',                         
      // 'fallback_cb'     => array('WPTheme\\Navwalker','fallback'),
      'walker'          => $this
    );

    $menu = wp_parse_args($config, $menu);

    wp_nav_menu($menu);

  }

  public function menu_css_class( $classes, $item, $args, $depth )
  {
    // Bootstrap nav-item class
    $classes[] = 'nav-item';

    // Bootstrap dropdown if has children
    if( in_array('menu-item-has-children', $classes, TRUE) )
    {
      $classes[] = 'dropdown';
    }

    if( $item->object == 'page' && $item->object_id )
    {      
      $classes[] = 'menu-item-page-' . wp_basename(get_permalink($item->object_id)); 
    }

    if( in_array('current-menu-item', $classes, TRUE) )
    {
      $classes[] = 'current';
    }
      


    return $classes;
    
  }


  public function link_attributes( $attributes, $item, $args, $depth = 0 )
  {
    if( $item->classes && in_array('menu-item-has-children', $item->classes, TRUE) )
    {

    }

    if( isset($attributes['class']) )
    {
      $attributes['class'] .= ' nav-link';
    }
    else
    {
      $attributes['class'] = 'nav-link';
    }

    return $attributes;
  }


  /**
   * Start Level.
   *
   * @see Walker::start_lvl()
   * @since 3.0.0
   *
   * @access public
   * @param mixed $output Passed by reference. Used to append additional content.
   * @param int   $depth (default: 0) Depth of page. Used for padding.
   * @param array $args (default: array()) Arguments.
   * @return void
   */
  public function start_lvl( &$output, $depth = 0, $args = array() ) 
  {
      $indent = str_repeat( "\t", $depth );

      // find all links with an id in the output.
      preg_match_all( '/(<a.*?id=\"|\')(.*?)\"|\'.*?>/im', $output, $matches );

      // with pointer at end of array check if we got an ID match.
      if ( end( $matches[2] ) ) {
        // build a string to use as aria-labelledby.
        $labledby = 'aria-labelledby="' . end( $matches[2] ) . '"';
      }

      $output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\" " . $labledby . ">\n";
  }


  /**
   * Start El.
   *
   * @see Walker::start_el()
   * @since 3.0.0
   *
   * @access public
   * @param mixed $output Passed by reference. Used to append additional content.
   * @param mixed $item Menu item data object.
   * @param int   $depth (default: 0) Depth of menu item. Used for padding.
   * @param array $args (default: array()) Arguments.
   * @param int   $id (default: 0) Menu item ID.
   * @return void
   */
  public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

    $indent   = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    $classes  = isset($item->classes) ? $item->classes : array();
    $dropdown = $args->has_children;
    $current  = in_array('current-menu-item', $classes, TRUE);

    $menuID   = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args );

    $classes[] = $menuID;

    $classes[] = 'nav-item';

    if( $item->object == 'page' && $item->object_id )
    {
      $slug = wp_basename(get_permalink($item->object_id));
      
      $classes[] = 'menu-item-page-' . $slug; 
      //$classes[] = 'menu-item-title-' . strtolower(str_replace(['_',' '],'-',$item->title));
    }

    if( $dropdown ) $classes[] = 'dropdown';
    if( $current ) $classes[] = 'current';
    
    $scope = 'itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement';

    // Opening Tag
    $item_open = '<li ' . $scope  . ' id="' . $menuID . '" class="' . implode(' ', $classes) .'">';
    
    $atts = array();

    $atts['title']  = isset($item->attr_title) ? $item->attr_title : strip_tags($item->title);
    $atts['target'] = isset($item->target) ? $item->target : '';
    $atts['rel']    = isset($item->rel) ? $item->rel : '';

    if( $dropdown && 0 === $depth && $args->depth > 1 )
    {
            $atts['href']           = '#';
            $atts['data-toggle']    = 'dropdown';
            $atts['aria-haspopup']  = 'true';
            $atts['aria-expanded']  = 'false';
            $atts['class']          = 'dropdown-toggle nav-link';
            $atts['id']             = 'menu-item-dropdown-' . $item->ID;
    }
    else
    {       
            $atts['href']  = ! empty( $item->url ) ? $item->url : '';
            $atts['class'] = $depth > 0 ? 'dropdown-item' : 'nav-link';
    }



    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

    $attributes = '';

    foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
            }
    }

    $item_title = apply_filters( 'the_title', $item->title, $item->ID );
    $item_link  = $args->link_before . '<a' . $attributes . '>' . $item_title . $args->link_after . '</a>';
    
    // Build full output
    $item_output = $args->before . $item_open . $item_link . $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

  }


  /**
   * Traverse elements to create list from elements.
   *
   * Display one element if the element doesn't have any children otherwise,
   * display the element and its children. Will only traverse up to the max
   * depth and no ignore elements under that depth.
   *
   * This method shouldn't be called directly, use the walk() method instead.
   *
   * @see Walker::start_el()
   * @since 2.5.0
   *
   * @access public
   * @param mixed $element Data object.
   * @param mixed $children_elements List of elements to continue traversing.
   * @param mixed $max_depth Max depth to traverse.
   * @param mixed $depth Depth of current element.
   * @param mixed $args Arguments.
   * @param mixed $output Passed by reference. Used to append additional content.
   * @return null Null on failure with no changes to parameters.
   */
  public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
    
    if ( ! $element ) return; 

    $id_field = $this->db_fields['id'];

    // Display this element.
    if ( is_object( $args[0] ) ) 
    {
      $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] ); 
    }

    parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
  }


  /**
   * Menu Fallback
   * =============
   * If this function is assigned to the wp_nav_menu's fallback_cb variable
   * and a menu has not been assigned to the theme location in the WordPress
   * menu manager the function with display nothing to a non-logged in user,
   * and will add a link to the WordPress menu manager if logged in as an admin.
   *
   * @param array $args passed from the wp_nav_menu function.
   */
  public static function fallback( $args ) {
    if ( current_user_can( 'edit_theme_options' ) ) {

      /* Get Arguments. */
      $container = $args['container'];
      $container_id = $args['container_id'];
      $container_class = $args['container_class'];
      $menu_class = $args['menu_class'];
      $menu_id = $args['menu_id'];

      // initialize var to store fallback html.
      $fallback_output = '';

      if ( $container ) {
              $fallback_output = '<' . esc_attr( $container );
              if ( $container_id ) {
                      $fallback_output = ' id="' . esc_attr( $container_id ) . '"';
              }
              if ( $container_class ) {
                      $fallback_output = ' class="' . sanitize_html_class( $container_class ) . '"';
              }
              $fallback_output = '>';
      }
      $fallback_output = '<ul';
      if ( $menu_id ) {
              $fallback_output = ' id="' . esc_attr( $menu_id ) . '"'; }
      if ( $menu_class ) {
              $fallback_output = ' class="' . esc_attr( $menu_class ) . '"'; }
      $fallback_output = '>';
      $fallback_output = '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" title="">' . esc_attr( 'Add a menu', '' ) . '</a></li>';
      $fallback_output = '</ul>';
      if ( $container ) {
              $fallback_output = '</' . esc_attr( $container ) . '>';
      }

      // if $args has 'echo' key and it's true echo, otherwise return.
      if ( array_key_exists( 'echo', $args ) && $args['echo'] ) {
              echo $fallback_output; // WPCS: XSS OK.
      } else {
              return $fallback_output;
      }
    } // End if().
  }




}