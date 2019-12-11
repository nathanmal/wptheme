<?php 

/**
* WP Theme core package
************************************************************************************/

return array(

  /**
   * Package name
   */
  'name' => 'wptheme',

  /**
   * Package title
   */
  'title' => 'WP Theme',

  /**
   * Package version
   */
  'version' => THEME_VERSION,


  /**
   * Javascript Assets
   */
  'js' => array(

    /**
     * Local Javascript
     */
    'local' => array(
      array(
        'src' => '/dist/theme.js',
      )
    ),
  ),


  /**
   * Stylesheets
   */
  'css' => array(

    /**
     * Local Stylesheets
     */
    'local' => array(
      array(
        'src' => '/dist/theme.css'
      )
    ),

  )

);