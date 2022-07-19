<?php
/**
 * Styles settings page
 *
 * @package WPTheme
 */

namespace WPTheme\Admin\Page;

use WPTheme\Admin\Page;

class Styles extends Page
{
  /**
   * Settings page title
   * @var string
   */
  public $title = 'Styles';

  /**
   * Settings menu title
   * @var string
   */
  public $menu_title = 'Styles';

  /**
   * Settings page slug
   * @var string
   */
  public $slug = 'styles';

  /**
   * Settings group
   * @var string
   */
  public $group = 'styles';


  public function register_settings()
  {
    
    $this->register_section('header', 'Header Styles', 'Enter your header styles');

    $config = ['options'=>[
      'hidden' => 'Hidden',
      'show' => 'Show'
    ]];

    $this->register_setting('header_type', 'Header Type', 'select', 'header', $config);

    $this->register_setting('header_height', 'Header Height', 'integer', 'header');


    

  }




  public function render()
  {




  }





}