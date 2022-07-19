<?php


/**
 * Get template instance class
 * @return [type] [description]
 */
function wpt_template()
{
  return wpt()->template->getPath();
}


/**
 * Get the current template type
 * @return [type] [description]
 */
function wpt_template_type()
{
  return wpt()->template->getType();
}


/**
 * Load a partial view file
 *
 * This function uses the built-in get_template_part() function, but allows for returning the output as a string
 * @param  string  $path   [description]
 * @param  array   $data   [description]
 * @param  boolean $return [description]
 * @return [type]          [description]
 */
function wpt_partial( string $slug, string $name = NULL, array $args = [], $return = FALSE )
{
  // Start output buffering
  ob_start();

  // Prefix path with partials directory
  $path = wpt_prefix( $slug, 'partials/' );

  // If template does not exist, then output a warning
  if( FALSE === get_template_part( $path, $name, $args ) )
  {
    $content = '[Partial missing: ' . $path . ']';
  }
  else
  {
    $content = ob_get_contents();
  }
  
  // End output buffering and clear buffer
  ob_end_clean();

  // Return content as string if specified
  if( $return ) return $content;

  // Otherwise output it
  echo $content;
}