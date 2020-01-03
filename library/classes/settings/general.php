<?php 

namespace WPTheme\Settings;

use WPTheme\Settings;

class General extends Settings
{

  public function add_meta_boxes()
  {
    add_meta_box(
        'wpt-test',                       /* Meta Box ID */
        'Testing',                   /* Title */
        array($this,'metabox_testing'),  /* Function Callback */
        Settings::$screen,                    /* Screen: Our Settings Page */
        'normal',                             /* Context */
        'high'                                /* Priority */
    );

  }


  public function metabox_testing()
  {
    $this->do_setting('testing.boolean', 'boolean', 'Test Boolean');

    $this->do_setting('testing.checkbox', 'checkbox', 'Test Checkbox');


    $config = array(
      'choices' => array('one','two','three')
    );

    $this->do_setting('testing.radio', 'radio', 'Test Radio', $config);

    $this->do_setting('testing.yesno', 'yesno', 'Test Yes/No');

    $this->do_setting('testing.text', 'text', 'Test Text', array('note'=>'This is a note'));

    $this->do_setting('testing.textarea', 'textarea', 'Test Textarea');


    $this->do_setting('testing.email', 'email', 'Test Email');
    $this->do_setting('testing.image', 'image', 'Test Image');
    $this->do_setting('testing.json', 'json', 'Test JSON');
    $this->do_setting('testing.latlong', 'latlong', 'Test Latlong');
    
    $this->do_setting('testing.select', 'select', 'Test Select', $config);
   
  }


  public function render()
  {
    ?>
    
    <p>General settings go here</p>

    <?php 



  }


  public function title()
  {
    return 'Settings';
  }
}