<?php 

namespace WPTheme\Admin\Page;

use WPTheme\Admin\Page;

class Seo extends Page
{ 
  public $menu_order = 1;

  public function add_meta_boxes()
  {
    add_meta_box(
        'wpt-seo-checklist',                       /* Meta Box ID */
        'SEO Checklist',                   /* Title */
        array($this,'metabox_checklist'),  /* Function Callback */
        Page::$slug,                    /* Screen: Our Settings Page */
        'normal',                             /* Context */
        'high'                                /* Priority */
    );


    add_meta_box(
        'wpt-seo-organization',                       /* Meta Box ID */
        'Organization',                   /* Title */
        array($this,'metabox_organization'),  /* Function Callback */
        Page::$slug,                    /* Screen: Our Settings Page */
        'normal',                             /* Context */
        'high'                                /* Priority */
    );

    add_meta_box(
        'wpt-seo-keywords',                       /* Meta Box ID */
        'Keywords & Description',                   /* Title */
        array($this,'metabox_keywords'),  /* Function Callback */
        Page::$slug,                    /* Screen: Our Settings Page */
        'normal',                             /* Context */
        'high'                                /* Priority */
    );
  }


  public function metabox_checklist()
  {

    echo 'checklist';
      

  }

  public function metabox_organization()
  {
    echo 'organization';
  }

  public function metabox_keywords()
  {
    echo 'organization';
  }


  public function title()
  {
    return 'SEO';
  }
  

}