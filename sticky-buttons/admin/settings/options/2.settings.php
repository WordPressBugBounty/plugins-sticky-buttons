<?php

use StickyButtons\WOWP_Plugin;

defined( 'ABSPATH' ) || exit;

$args = [

	'properties' => [
		'title' => __( 'Properties', 'sticky-buttons' ),
		'icon'  => 'wpie_icon-ruler-pen',
		[
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
		],
	],

	'position' => [
		'title' => __( 'Position', 'sticky-buttons' ),
		'icon'  => 'wpie_icon-pointer',
		[
			'position' => [
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
		],

		[
			'position_type' => [
				'type'    => 'select',
				'title'   => __( 'Type', 'sticky-buttons' ),
				'options' => [
					''         => __( 'Fixed', 'sticky-buttons' ),
					'absolute' => __( 'Absolute', 'sticky-buttons' ),
					'static'   => __( 'Static', 'sticky-buttons' ),
				]
			],

			'selector' => [
				'type'  => 'text',
				'title' => __( 'Selector', 'sticky-buttons' ),
			],

			'inserted' => [
				'type'  => 'select',
				'title' => __( 'Inserted', 'sticky-buttons' ),
				'options' => [
					'prepend' => __( 'At Start', 'sticky-buttons' ),
					'append'  => __( 'At End', 'sticky-buttons' ),
				]
			],
		],

	],

	'appearance' => [
		'title' => __( 'Appearance', 'sticky-buttons' ),
		'icon'  => 'wpie_icon-paintbrush',
		[
			'shape'  => [
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
			'shadow' => [
				'type'  => 'select',
				'title' => __( 'Shadow', 'sticky-buttons' ),
				'val'   => '',
				'atts'  => [
					'shadow' => __( 'Yes', 'sticky-buttons' ),
					''       => __( 'No', 'sticky-buttons' ),
				],
			],
			'gap'    => [
				'type'  => 'number',
				'title' => __( 'Space', 'sticky-buttons' ),
				'val'   => '0',
				'atts'  => [
					'min'  => 0,
					'step' => 1,
				],
				'addon' => 'px'
			],
		],
		[
			'size' => [
				'type'  => 'select',
				'title' => __( 'Size', 'sticky-buttons' ),
				'val'   => '-medium',
				'atts'  => [
					'-small'  => __( 'Small', 'sticky-buttons' ),
					'-medium' => __( 'Medium', 'sticky-buttons' ),
					'-large'  => __( 'Large', 'sticky-buttons' ),
				],
			],

		],
	],

];

$args = apply_filters( WOWP_Plugin::PREFIX . '_settings_options', $args );

$data = [
	'args' => $args,
	'opt'  => [],
];

foreach ( $args as $i => $group ) {

	if ( is_array( $group ) ) {

		foreach ( $group as $k => $v ) {

			if ( is_array( $v ) ) {
				foreach ( $v as $key => $val ) {
					$data['opt'][ $key ] = $val;
				}
			}
		}
	}
}

return $data;