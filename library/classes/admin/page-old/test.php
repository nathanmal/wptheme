<?php 

namespace WPTheme\Admin\Page;

use WPTheme\Admin\Page;

class Test extends Page
{

  public $menu_order = 2;

  public function register_settings()
  {
    $this->register_setting('test.boolean',  'boolean', 'Test Boolean');
    $this->register_setting('test.checkbox', 'checkbox', 'Test Checkbox');
    $this->register_setting('test.radio', 'radio', 'Test Radio', array('choices' => array('one','two','three')));
    $this->register_setting('test.yesno', 'yesno', 'Test Yes/No');
    $this->register_setting('test.text', 'text', 'Test Text', array('note' => 'This is a note'));
    $this->register_setting('test.textarea', 'textarea', 'Test Textarea');
    $this->register_setting('test.email', 'email', 'Test Email');
    $this->register_setting('test.image', 'image', 'Test Image');
    $this->register_setting('test.json', 'json', 'Test JSON');
    $this->register_setting('test.latlong', 'latlong', 'Test Latlong');
    $this->register_setting('test.select', 'select', 'Test Select', array('choices' => array('one','two','three')));
  }


  
  public function add_meta_boxes()
  {
    add_meta_box(
        'wpt-test',                       // Meta Box ID
        'Testing',                        // Title
        array($this,'metabox_testing'),   // Function Callback
        Page::$slug,                      // Screen: Our Settings Page
        'normal',                         // Context
        'high'                            // Priority
    );

  }

  /**
   * Field tests
   * @return [type] [description]
   */
  public function metabox_testing()
  {
    $this->render_setting('test.boolean');
    $this->render_setting('test.checkbox');
    $this->render_setting('test.radio');
    $this->render_setting('test.yesno');
    $this->render_setting('test.text');
    $this->render_setting('test.textarea');
    $this->render_setting('test.email');
    $this->render_setting('test.image');
    $this->render_setting('test.json');
    $this->render_setting('test.latlong');
    $this->render_setting('test.select');
   
  }


  public function render()
  {
    ?>
    
    <p>General settings go here</p>

    <?php 



  }


  public function title()
  {
    return 'Test';
  }
}