<?php


/**
* Print out an variable in a <pre></pre> block
* @param  [type] $obj [description]
* @return [type]      [description]
*/
if( ! function_exists('pre') ) 
{
  function pre($obj)
  {
      echo '<div class="pre-debug"><pre>';
      if( is_array($obj) ) {
          print_r($obj);
      } else {
          var_dump($obj);
      }
      echo '</pre></div>';
  }
}
