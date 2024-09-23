<?php


use StickyButtons\Settings_Helper;

defined( 'ABSPATH' ) || exit;

$show = [
	'general_start' => __( 'General', 'sticky-buttons' ),
	'everywhere'    => __( 'Everywhere', 'sticky-buttons' ),
	'shortcode'     => __( 'Shortcode', 'sticky-buttons' ),
	'general_end'   => __( 'General', 'sticky-buttons' ),
];


$args = [
	//region Display Rules
	'show' => [
		'type'  => 'select',
		'title' => __( 'Display', 'sticky-buttons' ),
		'val'   => 'everywhere',
		'atts'  => $show,
	],

	//endregion


	//region Other
	'fontawesome' => [
		'type'  => 'checkbox',
		'title' => __( 'Disable Font Awesome Icon', 'sticky-buttons' ),
		'val'   => 0,
		'label' => __( 'Disable', 'sticky-buttons' ),
	],

	//endregion

	//region Responsive Visibility
	'screen'       => [
		'type'  => 'number',
		'title' => [
			'label'  => __( 'Hide on smaller screens', 'sticky-buttons' ),
			'name'   => 'include_mobile',
			'toggle' => true,
		],
		'val'   => 480,
		'addon' => 'px',
	],

	'screen_more' => [
		'type'  => 'number',
		'title' => [
			'label'  => __( 'Hide on larger screens', 'sticky-buttons' ),
			'name'   => 'include_more_screen',
			'toggle' => true,
		],
		'val'   => 1024,
		'addon' => 'px'
	],

	//endregion


];


return $args;
