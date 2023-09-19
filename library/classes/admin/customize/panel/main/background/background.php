<?php

namespace WPTheme\Admin\Customize\Panel\Main\Background;

use WPTheme\Admin\Customize\Setting;

class Background extends Setting
{

	public function __construct($section)
	{
		
		$s = new \Kirki\Field\Background(
			[
				'settings'    => 'background_setting',
				'label'       => esc_html__( 'Background Control', 'kirki' ),
				'description' => esc_html__( 'Background conrols are pretty complex! (but useful if used properly)', 'kirki' ),
				'section'     => $section,
				'responsive' => TRUE,
				'default'     => [
					'background-color'      => 'rgba(20,20,20,.8)',
					'background-image'      => '',
					'background-repeat'     => 'repeat',
					'background-position'   => 'center center',
					'background-size'       => 'cover',
					'background-attachment' => 'scroll',
				],
				'transport'   => 'auto',
				'output'      => [
					[
						'element' => 'body',
					],
				],
			]
		);

		
	}


}