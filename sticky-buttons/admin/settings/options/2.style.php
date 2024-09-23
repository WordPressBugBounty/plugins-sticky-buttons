<?php

defined( 'ABSPATH' ) || exit;

return [
	//region Properties
	'zindex' => [
		'type'  => 'number',
		'title' => __( 'Z-index', 'sticky-buttons' ),
		'val'   => '9',
		'atts'  => [
			'min'         => '0',
			'step'        => '1',
			'placeholder' => '9',
		],
	],

	'animation' => [
		'type'  => 'select',
		'title' => __( 'Animation', 'sticky-buttons' ),
		'val'   => '',
		'atts'  => [
			''             => __( 'None', 'sticky-buttons' ),
		]
	],

	//endregion

	//region Location
	'position'  => [
		'type'  => 'select',
		'title' => __( 'Position', 'sticky-buttons' ),
		'val'   => '-left-center',
		'atts'  => [
			'-left-top'      => __( 'Left Top', 'sticky-buttons' ),
			'-left-center'   => __( 'Left Center', 'sticky-buttons' ),
			'-left-bottom'   => __( 'Left Bottom', 'sticky-buttons' ),
			'-right-top'     => __( 'Right Top', 'sticky-buttons' ),
			'-right-center'  => __( 'Right Center', 'sticky-buttons' ),
			'-right-bottom'  => __( 'Right Bottom', 'sticky-buttons' ),
			'-top-left'      => __( 'Top Left', 'sticky-buttons' ),
			'-top-center'    => __( 'Top Center', 'sticky-buttons' ),
			'-top-right'     => __( 'Top Right', 'sticky-buttons' ),
			'-bottom-left'   => __( 'Bottom Left', 'sticky-buttons' ),
			'-bottom-center' => __( 'Bottom Center', 'sticky-buttons' ),
			'-bottom-right'  => __( 'Bottom Right', 'sticky-buttons' ),
		],
	],

	'm_block' => [
		'type'  => 'number',
		'title' => __( 'Margin Block', 'sticky-buttons' ),
		'val'   => '0',
		'addon' => 'px'
	],

	'm_inline' => [
		'type'  => 'number',
		'title' => __( 'Margin Inline', 'sticky-buttons' ),
		'val'   => '0',
		'addon' => 'px'
	],
	//endregion

	//region Appearance
	'shape'    => [
		'type'  => 'select',
		'title' => __( 'Shape', 'sticky-buttons' ),
		'val'   => '-square',
		'atts'  => [
			'-square'  => __( 'Square', 'sticky-buttons' ),
			'-rsquare' => __( 'Rounded square', 'sticky-buttons' ),
			'-circle'  => __( 'Circle', 'sticky-buttons' ),
			'-ellipse' => __( 'Ellipse', 'sticky-buttons' ),
		],
	],

	'size'    => [
		'type'  => 'select',
		'title' => __( 'Size', 'sticky-buttons' ),
		'val'   => '-medium',
		'atts'  => [
			'-medium' => __( 'Medium', 'sticky-buttons' ),
		],
	],

	'shadow'    => [
		'type'  => 'select',
		'title' => __( 'Shadow', 'sticky-buttons' ),
		'val'   => '',
		'atts'  => [
			'shadow' => __( 'Yes', 'side-menu' ),
			''       => __( 'No', 'side-menu' ),
		],
	],

	'gap' => [
		'type'  => 'number',
		'title' => __( 'Space', 'sticky-buttons' ),
		'val'   => '0',
		'atts'  => [
			'min'  => 0,
			'step' => 1,
		],
		'addon' => 'px'
	],
	//endregion

];