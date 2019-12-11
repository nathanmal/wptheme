<?php 

/**
* Bootstrap 
* 
* @version 4.3.1 
* 
************************************************************************************/

return array(

  /**
   * Package name
   */
  'name' => 'bootstrap',

  /**
   * Package version
   */
  'version' => '4.3.1',

  /**
   * Package title
   */
  'title' => 'Bootstrap',
  

  /**
   * Javascript Assets
   */
  'js' => array(

    'dependencies' => array('jquery'),

    /**
     * Local Javascript
     */
    'local' => array(
      array(
        'src' => '/package/bootstrap/4.3.1/js/bootstrap.min.js',
      )
    ),

    /**
     * CDN Javascript
     */
    'cdn' => array(
      array(
        'src' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js',
        'integrity' => 'sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM',
        'crossorigin' => 'anonymous'
      )
    )
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
        'src' => '/package/bootstrap/4.3.1/css/bootstrap.min.css'
      )
    ),

    /**
     * CDN Stylesheets
     */
    'cdn' => array(
      array(
        'src' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css',
        'integrity' => 'sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T',
        'crossorigin' => 'anonymous'
      )
    )


  )

);