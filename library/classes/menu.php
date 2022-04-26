<?php

namespace WPTheme;


class Menu
{
  use \WPTheme\Traits\Singleton;



  public function __construct()
  {
    add_filter('nav_menu_css_class', array($this, 'menu_css_class'), 10, 4 );

    add_filter('nav_menu_link_attributes', array($this, 'link_attributes'), 10, 4);
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



  public function link_attributes( $attributes, $item, $args, $depth )
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










}



Menu::instance();