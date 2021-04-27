<?php

namespace WPTheme\Shortcode;

use WPTheme\Shortcode;
use joshtronic\LoremIpsum;

class Lipsum extends Shortcode
{

  public function run( array $attributes, string $content, string $tag )
  {
    $generator = new LoremIpsum();

    $lipsum = '';

    if( isset($attributes['paragraphs']) )
    {
      $p = intval($attributes['paragraphs']) OR 1;

      $lipsum = $generator->paragraphs($p,'p');
    }
    else if( isset($attributes['sentences']) )
    {
      $s = intval($attributes['sentences']) OR 1;

      $lipsum = $generator->sentences($s);
    }
    else if( isset($attributes['words']) )
    {
      $w = intval($attributes['words']) OR 1;

      $lipsum = $generator->words($w);
    }
    else
    {
      // Default show paragraphs
      $lipsum = $generator->paragraphs(2);
    }

    return $lipsum;
  }

}