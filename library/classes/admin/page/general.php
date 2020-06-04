<?php 

namespace WPTheme\Admin\Page;

use WPTheme\Admin\Page;

class General extends Page
{

  /**
   * Should be 0 for general settings
   * @var integer
   */
  public $menu_order = 0;


  /**
   * General settings metaboxes
   * @var array
   */
  public $metaboxes = array(
    'analytics' => array(
      'title'    => 'Google Analytics',
      'context'  => 'normal',
      'priority' => 'high'
    ),
    'contact' => array(
      'title'    => 'Contact Card',
      'context'  => 'normal',
      'priority' => 'high'
    )
  );

  /**
   * Title for menus, etc
   * @return [type] [description]
   */
  public function title()
  {
    return 'General Settings';
  }

  /**
   * Register settings
   * @return [type] [description]
   */
  public function register_settings()
  {
    // Google analytics tag
    $this->register_setting('google.analytics.ua','text','Tracking ID', array('placeholder' => 'UA-XXXXXXX-XX'));
    $this->register_setting('contact.name', 'text', 'Organization Name');
    $this->register_setting('contact.address', 'text', 'Address');
    $this->register_setting('contact.address2', 'text', 'Address (line 2)');

  }


  /**
   * Field tests
   * @return [type] [description]
   */
  public function metabox_analytics()
  {
    $this->render_setting('google.analytics.ua');
  }


  /**
   * Field tests
   * @return [type] [description]
   */
  public function metabox_contact()
  {
    $this->render_setting('contact.name');
    $this->render_setting('contact.address');
    $this->render_setting('contact.address2');
  }


  
}