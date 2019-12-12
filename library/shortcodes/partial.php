<?php
if ( ! function_exists('wpt_shortcode_partial') ) 
{
    function wpt_shortcode_partial( $args, $content, $tag )
    {
      if( empty($args) )
      {
        echo '[wpt:partial No view specified]';
        return;
      }

      $view = $args[0];

      WPTheme\Theme::partial($view);
    }

    add_shortcode( 'wpt:partial' , 'wpt_shortcode_partial' );
}