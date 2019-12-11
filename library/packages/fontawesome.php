<?php 

/**
* Font Awesome 
* 
* @version 5.11.2 
* 
************************************************************************************/

return array(

  /**
   * Package name
   */
  'name' => 'fontawesome',

  /**
   * Package version
   */
  'version' => '5.11.2',

  /**
   * Package title
   */
  'title' => 'Font Awesome',
  

  /**
   * Javascript Assets
   */
  'js' => array(),


  /**
   * Stylesheets
   */
  
  'css' => array(
    /**
     * Local Stylesheets
     */
    'local' => array(
      array(
        'name' => 'icons',
        'src'  => '/package/fontawesome/5.11.2/css/all.min.css'
      ),
      array(
        'src'  => '/package/fontawesome/5.11.2/css/fontawesome.min.css'
      )
    ),

    /**
     * CDN Stylesheets
     */
    'cdn' => array(

      array(
        'name'        => 'icons',
        'src'         => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css',
        'integrity'   =>'sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=',
        'crossorigin' => 'anonymous'
      ),
      array(
        'src'         => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/fontawesome.min.css',
        'integrity'   => 'sha256-/sdxenK1NDowSNuphgwjv8wSosSNZB0t5koXqd7XqOI=',
        'crossorigin' => 'anonymous'
      )
    )
  )
);