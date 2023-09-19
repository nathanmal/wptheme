<?php

namespace WPTheme\Admin\Customize;


class Section
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



	protected $panel = '';


	protected $settings = [];



	public function __construct( $panel = '' )
	{
		$this->panel = $panel;
		$this->register();
	}


	public function getPanel()
	{
		return $this->panel;
	}

	/**
	 * Get section ID
	 * @return [type] [description]
	 */
	public function getId()
	{
		$id = $this->id ?? strtolower( wpt_class_shortname($this) );
		
		if( $this->panel )
		{
			$id = wpt_prefix( $id, $this->panel . '_' );
		}

		return $id;
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
	 * Register Section Controls
	 * @return [type] [description]
	 */
	public function register(){}


	public function setting( $setting )
	{
		$class = '\\WPTheme\\Admin\\Customize\\';

		if( $this->panel )
		{
			$class .= 'Panel\\' . ucfirst($this->panel) . '\\';
		}

		$class .= wpt_class_shortname($this) . '\\' . ucfirst($setting);

		$this->settings[$setting] = new $class( $this->getId() );

	}

}