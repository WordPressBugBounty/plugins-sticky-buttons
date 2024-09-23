<?php

use StickyButtons\Settings_Helper;

defined( 'ABSPATH' ) || exit;

$args = [
	'item_tooltip' => [
		'type'  => 'text',
		'title' => __( 'Label Text', 'sticky-buttons' ),
	],

	'item_type' => [
		'type'  => 'select',
		'title' => __( 'Type', 'sticky-buttons' ),
		'atts'  => Settings_Helper::item_type(),
	],

	'item_link' => [
		'type'  => 'text',
		'title' => __( 'Link', 'sticky-buttons' ),
		'class' => 'is-hidden',
	],


	// Icons
	'item_icon'  => [
		'type'  => 'select',
		'title' => __( 'Icon', 'sticky-buttons' ),
		'atts'  => Settings_Helper::icons(),
		'class' => 'wpie-icon-box',
	],


	// Style
	'color'            => [
		'type'  => 'text',
		'val'   => '#383838',
		'atts'  => [
			'class'              => 'wpie-color',
			'data-alpha-enabled' => 'true',
		],
		'title' => __( 'Font Color', 'sticky-buttons' ),
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


	// Attributes
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

	'item_text' => [
		'type'  => 'textarea',
		'class' => 'is-full',
		'atts'  => [
			'class' => 'wpie-texteditor'
		]
	],

];

$prefix  = 'menu_1-';
$newArgs = [];

foreach ( $args as $key => $value ) {
	$newArgs[ $prefix . $key ] = $value;
}

return $newArgs;