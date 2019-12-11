<?php 

/**
* Jquery 
* 
* @version 3.4.1
* 
************************************************************************************/

return array(

  /**
   * Package name
   */
  'name' => 'jquery',

  /**
   * Package title
   */
  'title' => 'jQuery',

  /**
   * Package version
   */
  'version' => '3.4.1',

  /**
   * Javascript Assets
   */
  'js' => array(

    /**
     * Local Javascript
     */
    'local' => array(
      array(
        'src' => '/package/jquery/3.4.1/jquery-3.4.1.min.js',
      )
    ),

    /**
     * CDN Javascript
     */
    'cdn' => array(
      array(
        'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js',
        'integrity' => 'sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=',
        'crossorigin' => 'anonymous',
      )
    )
  )

  
);