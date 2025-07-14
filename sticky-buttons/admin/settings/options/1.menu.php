<?php

use StickyButtons\Settings_Helper;
use StickyButtons\WOWP_Plugin;

defined( 'ABSPATH' ) || exit;

$args = [

	'style' => [
		[
			'item_tooltip' => [
				'type'  => 'text',
				'title' => __( 'Label Text', 'sticky-buttons' ),
			],

			'hold_open' => [
				'type'  => 'checkbox',
				'title' => __( 'Hold open', 'sticky-buttons' ),
				'label' => __( 'Enable', 'sticky-buttons' ),
			],
		],

		[
			'label_font' => [
				'type'  => 'select',
				'title' => __( 'Font Family', 'sticky-buttons' ),
				'atts'  => [
					'inherit'         => __( 'Use Your Themes', 'sticky-buttons' ),
					'Tahoma'          => __( 'Tahoma', 'sticky-buttons' ),
					'Georgia'         => __( 'Georgia', 'sticky-buttons' ),
					'Comic Sans MS'   => __( 'Comic Sans MS', 'sticky-buttons' ),
					'Arial'           => __( 'Arial', 'sticky-buttons' ),
					'Lucida Grande'   => __( 'Lucida Grande', 'sticky-buttons' ),
					'Times New Roman' => __( 'Times New Roman', 'sticky-buttons' ),
				],
			],

			'label_style' => [
				'type'  => 'select',
				'title' => __( 'Font Style', 'sticky-buttons' ),
				'atts'  => [
					'normal' => __( 'Normal', 'sticky-buttons' ),
					'italic' => __( 'Italic', 'sticky-buttons' ),
				],
			],

			'label_weight' => [
				'type'  => 'select',
				'title' => __( 'Font Weight ', 'sticky-buttons' ),
				'atts'  => [
					'normal'  => __( 'Normal', 'sticky-buttons' ),
					'lighter' => __( 'Lighter', 'sticky-buttons' ),
					'bold'    => __( 'Bold', 'sticky-buttons' ),
					'bolder'  => __( 'Bolder', 'sticky-buttons' ),
				],
			],
		],

		[
			'color' => [
				'type'  => 'text',
				'val'   => '#383838',
				'atts'  => [
					'class'              => 'wpie-color',
					'data-alpha-enabled' => 'true',
				],
				'title' => __( 'Color', 'sticky-buttons' ),
			],

			'bcolor' => [
				'type'  => 'text',
				'val'   => '#81d742',
				'atts'  => [
					'class'              => 'wpie-color',
					'data-alpha-enabled' => 'true',
				],
				'title' => __( 'Background', 'sticky-buttons' ),
			],
		],

	],

	'type' => [
		[
			'item_type' => [
				'type'  => 'select',
				'title' => __( 'Type', 'sticky-buttons' ),
				'atts'  => [

					'links_start'  => __( 'Links', 'sticky-buttons' ),
					'link'          => __( 'Link', 'sticky-buttons' ),
					'links_end'  => __( 'Links', 'sticky-buttons' ),

					'users_start'  => __( 'User Links', 'sticky-buttons' ),
					'login'        => __( 'Login', 'sticky-buttons' ),
					'logout'       => __( 'Logout', 'sticky-buttons' ),
					'lostpassword' => __( 'Lostpassword', 'sticky-buttons' ),
					'register'     => __( 'Register', 'sticky-buttons' ),
					'users_end'    => __( 'User Links', 'sticky-buttons' ),

					'contact_start' => __( 'Contact Links', 'sticky-buttons' ),
					'email'         => __( 'Email', 'sticky-buttons' ),
					'telephone'     => __( 'Telephone', 'sticky-buttons' ),
					'contact_end'   => __( 'Contact Links', 'sticky-buttons' ),
				],
			],

			'item_link' => [
				'type'  => 'text',
				'title' => __( 'Link', 'sticky-buttons' ),
				'class' => 'is-hidden',
			],


		],
	],

	'icon' => [
		[
			'item_icon' => [
				'type'    => 'text',
				'title'   => __( 'Icon', 'sticky-buttons' ),
				'value'   => 'fas fa-wand-magic-sparkles',
				'options' => [
					'class' => 'wpie-icon-box',
				]
			],
		],
	],

	'attributes' => [
		[
			'button_id' => [
				'type'  => 'text',
				'title' => __( 'ID for element', 'sticky-buttons' ),
			],

			'button_class' => [
				'type'  => 'text',
				'title' => __( 'Class for element', 'sticky-buttons' ),
			],

			'link_rel' => [
				'type'  => 'text',
				'title' => __( 'Attribute: rel', 'sticky-buttons' ),
			],

			'aria_label' => [
				'type'  => 'text',
				'title' => __( 'Aria label', 'sticky-buttons' ),
			],
		],
	],

];

$args = apply_filters( WOWP_Plugin::PREFIX . '_menu_options', $args );


$prefix = 'menu_1-';
$data   = [
	'args' => $args,
	'opt'  => [],
	'tabs' => [],
];

foreach ( $args as $i => $group ) {
	$data['tabs'][] = $i;

	if ( is_array( $group ) ) {

		foreach ( $group as $k => $v ) {

			foreach ( $v as $key => $val ) {
				$group_key                 = $prefix . $key;
				$data['opt'][ $group_key ] = $val;
			}

		}
	}
}

return $data;