<?php 

namespace WPTheme\Settings;

use WPTheme\Settings;

class Contact extends Settings
{ 

  public function add_meta_boxes()
  {
    add_meta_box(
        'wpt-contact-info',                       /* Meta Box ID */
        'Contact Info',                   /* Title */
        array($this,'metabox_info'),  /* Function Callback */
        Settings::$screen,                    /* Screen: Our Settings Page */
        'normal',                             /* Context */
        'high'                                /* Priority */
    );


    add_meta_box(
        'wpt-contact-form',                       /* Meta Box ID */
        'Contact Form',                   /* Title */
        array($this,'metabox_form'),  /* Function Callback */
        Settings::$screen,                    /* Screen: Our Settings Page */
        'normal',                             /* Context */
        'high'                                /* Priority */
    );
  }


  public function metabox_info()
  {

    $this->do_setting( 'contact.name','text', 'Business Name' );
    $this->do_setting( 'contact.address','text', 'Address' );
    $this->do_setting( 'contact.address2','text', 'Address (line 2)' );
    $this->do_setting( 'contact.city','text', 'City' );
    $this->do_setting( 'contact.state','text', 'State' );
    $this->do_setting( 'contact.country','text', 'Country' );
    $this->do_setting( 'contact.phone','text', 'Phone' );
    $this->do_setting( 'contact.fax','text', 'Fax' );
      

  }

  public function metabox_form()
  {
    $this->do_setting( 'contact.form.to','text', 'Email To' );
    $this->do_setting( 'contact.form.from','text', 'Email From' );
    $this->do_setting( 'contact.form.subject','text', 'Email Subject' );
    $this->do_setting( 'contact.form.thankyou','textarea', 'Thank You Message' );
  }


  


}