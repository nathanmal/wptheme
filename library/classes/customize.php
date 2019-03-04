<?php if ( ! defined( 'ABSPATH' ) ) exit;


class Customize
{

  protected static $settings = array(

    'navbar' => array(

      'title'       => 'Navbar',
      'description' => 'Navbar Defaults',
      'priority'    => 100,
      'settings'    => array(

        'theme_navbar_fixed' => array(
          'default'     => FALSE,
          'transport'   => 'refresh',
          'label'       => 'Fixed Navbar',
          'description' => 'Navbar will be fixed to the top of the window',
          'type'        => 'checkbox',
        ),

        'theme_navbar_hide' => array(
          'default'   => FALSE,
          'transport' => 'refresh',
          'label'     => 'Hide Fixed Navbar Until Scroll',
          'type'      => 'checkbox',
        ),

        'theme_navbar_text' => array(
          'default'   => NULL,
          'transport' => 'refresh',
          'label'     => 'Navbar Text',
          'type'      => 'select',
          'choices'   => array(NULL=>'None','light'=>'Light','dark'=>'Dark')
        ),

        'theme_navbar_background' => array(
          'default' => 'transprent',
          'label'   => 'Navbar Background',
          'type'    => 'select',
          'choices' => array('transparent'=>'None','light'=>'Light','dark'=>'Dark')
        )
      )
    )
  );





  public function init( $wp = NULL )
  {  
    
    foreach( Customize::$settings as $section => $settings )
    {
      $config = array();

      $config['title'] = element($settings, 'title', ucfirst($section) );

      if( $description = element($settings, 'description', FALSE) )
      {
        $config['description'] = $description;
      }

      if( $priority = element($settings, 'priority', FALSE) )
      {
        $config['priority'] = $priority;
      }

      $wp->add_section( $section, $config );


      foreach($settings['settings'] as $setting => $config )
      {
        $default     = element($config, 'default', NULL);
        $transport   = element($config, 'transport', 'refresh');
        $description = element($config, 'description', '');
        $type        = element($config, 'type', FALSE);
        $label       = element($config, 'label', ucfirst(str_replace('_',' ',$setting)));
        $choices     = element($config, 'choices', FALSE);

        $sconfig = array(
          'default'   => $default,
          'transport' => $transport
        );

        $wp->add_setting( $setting, $sconfig );

        $control = array(
          'label'       => __($label),
          'description' => __($description),
          'type'        => $type,
          'section'     => $section,
          'settings'    => $setting
        );

        if( $choices ) $control['choices'] = $choices;

        $wp->add_control( $setting, $control );


      }


    }

/* 
    $wp->add_section('theme_test', array(
      'title' => __('Testing'),
      'description' => 'Just Testing',
      'priority' => 120
    ));    

    $wp->add_setting('the_test', array(
      'default' => FALSE,
      'transport' => 'refresh',
      'capability' => 'edit_theme_options'
    ));

    $wp->add_control('the_test_control', array(
      'label' => __('Test Control'),
      'description' => 'Testing Controls',
      'type' => 'text',
      'section' => 'theme_test',
      'settings' => 'the_test'
    ));

   $wp->add_section('navbar', array(
      'title' => __('Navbar'),
      'description' => 'Navbar Defaults',
      'priority' => 120
    ));    

    $wp->add_setting('theme_navbar_fixed', array(
      'default' => FALSE,
      'transport' => 'refresh'
    ));

    $wp->add_control('theme_navbar_fixed', array(
      'label' => __('Fixed Navbar'),
      'description' => 'Navbar will be fixed to the top of the window',
      'type' => 'checkbox',
      'section' => 'navbar',
      'settings' => 'theme_navbar_fixed'
    ));
*/

   /* $wp->add_setting('theme_navbar_hide', array(
      'default' => FALSE,
      'transport' => 'refresh'
    ));

    $wp->add_control('theme_navbar_hide', array(
      'label' => __('Hide Fixed Navbar Until Scroll'),
      'type' => 'checkbox',
      'section' => 'navbar',
      'settings' => 'theme_navbar_hide'
    ));*/

   
  }




}