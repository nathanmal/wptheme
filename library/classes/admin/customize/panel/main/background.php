<?php

namespace WPTheme\Admin\Customize\Panel\Main;

use WPTheme\Admin\Customize\Section;

class Background extends Section
{



	/**
	 * The panel title
	 * @var string
	 */
	protected $title = 'Background';

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



	public function register()
	{
		$s = new \Kirki\Section(
			$this->getId(),
			[
				'title'       => $this->getTitle(),
				'description' => $this->getDescription(),
				'panel'       => $this->getPanel(),
				'priority'    => $this->getPriority(),
			]
		);

 

		//dump($s);

		$this->setting('background');
	}
}