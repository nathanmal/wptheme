<?php

namespace WPTheme\Admin\Customize;

class Panel
{
	/**
	 * The panel ID
	 * @var string
	 */
	protected $id = NULL;

	/**
	 * The panel title
	 * @var string
	 */
	protected $title = '';

	/**
	 * The panel priority
	 * @var integer
	 */
	protected $priority = 10;

	/**
	 * The panel desription
	 * @var string
	 */
	protected $description = '';


	/**
	 * The panel sections
	 * @var array
	 */
	protected $sections = [];


	/**
	 * Panel constructor
	 * @param [type] $customize [description]
	 */
	public function __construct()
	{	
		$this->register();
	}


	public function register(){}


	/**
	 * Get the panel ID
	 * @return [type] [description]
	 */
	public function getId()
	{
		return $this->id ?? strtolower( wpt_class_shortname($this) );
	}

	/**
	 * Get the panel title
	 * @return [type] [description]
	 */
	public function getTitle()
	{
		return esc_html__( $this->title, WPT_DOMAIN );
	}

	/**
	 * Get the panel description
	 * @return [type] [description]
	 */
	public function getDescription()
	{
		return esc_html__( $this->description, WPT_DOMAIN );
	}

	/**
	 * Get the panel priority
	 * @return [type] [description]
	 */
	public function getPriority()
	{
		return $this->priority;
	}

	/**
	 * Register section for this panel
	 * @param  [type] $section [description]
	 * @return [type]          [description]
	 */
	public function section( $section )
	{	
		$class = '\\WPTheme\\Admin\\Customize\\Panel\\' . wpt_class_shortname($this) . '\\' . ucfirst($section);
		$this->sections[$section] = new $class( $this->getId() );
	}




}