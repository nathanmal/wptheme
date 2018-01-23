<?php 


class Theme_Widget extends WP_Widget
{

    public $id = '';
    public $name = '';
    public $description = '';

    public function __construct(){

        $id = $this->id;
        $name = __($this->name, THEME_DOMAIN);
        $description = array(
            'description' => __($this->description, THEME_DOMAIN)
        );

        parent::__construct($id,$name,$description);
    }

    /**
     * Prints the widget on the front end
     * Extend this function
     * @param  [type] $args     [description]
     * @param  [type] $instance [description]
     * @return [type]           [description]
     */
    public function widget( $args, $instance ){}

    /**
     * Add input fields or content to the admin widget form
     * Extend this function
     * @param  [type] $instance [description]
     * @return [type]           [description]
     */
    public function form( $instance ){
    }

    /**
     * Update the widget with the data specified in form()
     * Extend this function 
     * @param  [type] $new_instance [description]
     * @param  [type] $old_instance [description]
     * @return [type]               [description]
     */
    public function update( $new_instance, $old_instance ){
        return $new_instance;
    }







}