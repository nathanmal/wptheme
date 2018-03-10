<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) exit;

class View
{


    /**
     * absolute path to the view
     * @var string
     */
    private $path = '';

    private $data = array();


    /**
     * Constructor
     * @param string  $path   path to the view, from either theme/views/<path> or library/views/<path>
     * @param array   $data   data array to be extracted
     * @param boolean $return if TRUE, returns view output as string, otherwise echo to output
     */
    public function __construct( $path, $data )
    {
        $this->path = $this->resolve($path);
        $this->data = $data;
    }

    public function set($name, $data = array())
    {
        if( isset($this->data[$name]) && is_array($this->data[$name]) ) {

        }
    }

    /**
     * Resolve view path
     * @param  [type] $path [description]
     * @return [type]       [description]
     */
    public function resolve( $path ) 
    {   
        $theme = THEME_DIR . '/theme/views/' . $path . '.php';
        $core  = THEME_DIR . '/library/views/' . $path . '.php';

        if( is_file($them) ) return $theme;
        if( is_file($core) ) return $core;
        return FALSE; 
    }

    public function render()
    {

    }

}