<?php

namespace WPTheme\Admin\Customize\Panel;

use WPTheme\Admin\Customize\Panel;

class Main extends Panel
{
	
	protected $title = 'Global Settings';


	protected $description = 'sdfsdfs';


	public function register()
	{
		new \Kirki\Panel(
			$this->getId(),
			[
				'priority'    => $this->getPriority(),
				'title'       => $this->getTitle(),
				'description' => $this->getDescription(),
			]
		);


		

		// dump($p);

		$this->section('background');
	}
}