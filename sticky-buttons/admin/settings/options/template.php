<?php

defined( 'ABSPATH' ) || exit;

$template = [
	'text' => [
		'type'  => 'text',
		'title' => __( 'Title', 'sticky-buttons' ),
		'val'   => '',
		'atts' => [
			'placeholder' => __( 'Placeholder', 'sticky-buttons' ),
		],
	],

	'number' => [
		'type'  => 'number',
		'title' => __( 'Title', 'sticky-buttons' ),
		'val'   => '',
		'atts' => [
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		],
	],

	'select' => [
		'type' => 'select',
		'title' => __('Title', 'sticky-buttons'),
		'val' => '1',
		'atts' => [
			'1' => __( '1', 'sticky-buttons' ),
			'2' => __( '2', 'sticky-buttons' ),
			'3' => __( '3', 'sticky-buttons' ),
		],
	],

	'color' => [
		'type'  => 'text',
		'val'   => '#ffffff',
		'title' => __( 'Color', 'sticky-buttons' ),
		'atts'  => [
			'class'              => 'wpie-color',
			'data-alpha-enabled' => 'true',
		],
	],

	'checkbox' => [
		'type'  => 'checkbox',
		'title' => __( 'Title', 'sticky-buttons' ),
		'label' => __( 'Enable', 'sticky-buttons' ),
	],

	'title' => [
		'label'  => __( 'Title', 'sticky-buttons' ),
		'name'   => '',
		'toggle' => true,
		'val'    => 1
	],

	'addon' => [
		'type' => 'select',
		'name' => '',
		'val'  => '',
		'atts' => [
			'1' => __( '1', 'sticky-buttons' ),
			'2' => __( '2', 'sticky-buttons' ),
			'3' => __( '3', 'sticky-buttons' ),
		],
	],

];