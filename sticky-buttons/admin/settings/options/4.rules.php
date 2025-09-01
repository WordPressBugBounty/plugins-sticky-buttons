<?php

use StickyButtons\WOWP_Plugin;

defined( 'ABSPATH' ) || exit;

$args = [
	'rules' => [
		'title' => __( 'Display Rules', 'sticky-buttons' ),
		'icon'  => 'wpie_icon-roadmap',
		[
			'show' => [
				'type'  => 'select',
				'title' => __( 'Display', 'sticky-buttons' ),
				'val'   => 'everywhere',
				'atts'  => [
					'general_start' => __( 'General', 'sticky-buttons' ),
					'shortcode'     => __( 'Shortcode', 'sticky-buttons' ),
					'everywhere'    => __( 'Everywhere', 'sticky-buttons' ),
					'general_end'   => __( 'General', 'sticky-buttons' ),
				],
			],
		],
	],

	'responsive' => [
		'title' => __( 'Responsive Visibility', 'sticky-buttons' ),
		'icon'  => 'wpie_icon-laptop-mobile',
		[
			'mobile_on' => [
				'type'  => 'checkbox',
				'title' => __( 'Mobile Rules', 'sticky-buttons' ),
				'label' => __( 'Enable', 'sticky-buttons' ),
			],
		],
		[

			'screen' => [
				'type'  => 'number',
				'title' => [
					'label'  => __( 'Hide on smaller screens', 'sticky-buttons' ),
					'name'   => 'mobile_screen_on',
					'toggle' => true,
				],
				'val'   => 480,
				'addon' => 'px',
			],

			'screen_more' => [
				'type'  => 'number',
				'title' => [
					'label'  => __( 'Hide on larger screens', 'sticky-buttons' ),
					'name'   => 'desktop_screen_on',
					'toggle' => true,
				],
				'val'   => 1024,
				'addon' => 'px'
			],
		],


	],

	'other' => [
		'title' => __( 'Other', 'sticky-buttons' ),
		'icon'  => 'wpie_icon-gear',
		[
			'fontawesome' => [
				'type'  => 'checkbox',
				'title' => __( 'Disable Font Awesome Icon', 'sticky-buttons' ),
				'val'   => 0,
				'label' => __( 'Disable', 'sticky-buttons' ),
			],
		],
	],

];

$args = apply_filters( WOWP_Plugin::PREFIX . '_rules_options', $args );

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
