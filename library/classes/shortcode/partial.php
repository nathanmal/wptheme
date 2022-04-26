<?php

namespace WPTheme\Shortcode;

use WPTheme\Shortcode;

class Partial extends Shortcode
{

  public function run( $attributes, $content, $tag )
  {
    $view = $attributes['view'] ?? '';
    $name = $attributes['name'] ?? '';

    if( empty($view) ) return '';

    $attributes['content'] = $content;

    return wpt_partial( $view, $name, $attributes, TRUE );
  }
} 