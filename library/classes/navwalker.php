<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) exit;

class Navwalker extends Walker_Nav_Menu
{

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
        public function start_lvl( &$output, $depth = 0, $args = array() ) {

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

        }




}