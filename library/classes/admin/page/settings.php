<?php
/**
 * Styles settings page
 *
 * @package WPTheme
 */

namespace WPTheme\Admin\Page;

use WPTheme\Admin\Page;

class Settings extends Page
{
  /**
   * Settings page title
   * @var string
   */
  public $title = 'Settings';

  /**
   * Settings menu title
   * @var string
   */
  public $menu_title = 'Settings';

  /**
   * Settings page slug
   * @var string
   */
  public $slug = 'settings';

  
  public $group = 'options';


}