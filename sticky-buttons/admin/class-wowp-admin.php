<?php

/**
 * Class WOWP_Admin
 *
 * The main admin class responsible for initializing the admin functionality of the plugin.
 *
 * @package    StickyButtons
 * @subpackage Admin
 * @author     Dmytro Lobov <hey@wow-company.com>, Wow-Company
 * @copyright  2024 Dmytro Lobov
 * @license    GPL-2.0+
 */

namespace StickyButtons;

use StickyButtons\Admin\AdminActions;
use StickyButtons\Admin\Dashboard;
use StickyButtons\Admin\Demo;
use StickyButtons\Admin\Settings;

defined( 'ABSPATH' ) || exit;

class WOWP_Admin {
	public function __construct() {
		Dashboard::init();
		AdminActions::init();
		Demo::init();

		add_action( 'wp_ajax_' . WOWP_Plugin::PREFIX . '_ajax_settings', [ Settings::class, 'save_item' ] );
		add_action( WOWP_Plugin::PREFIX . '_admin_header_links', [ $this, 'plugin_links' ] );
		add_filter( WOWP_Plugin::PREFIX . '_save_settings', [ $this, 'save_settings' ] );
		add_action( WOWP_Plugin::PREFIX . '_admin_load_assets', [ $this, 'load_assets' ] );

	}


	public function plugin_links(): void {
		$links = [
			'change' => __( 'Check for Updates', 'sticky-buttons' ),
			'rating' => __( 'Rate Us', 'sticky-buttons',  ),
			'pro'    => __( 'Pro Plugin', 'sticky-buttons' ),
			'docs'   => __( 'Documentation', 'sticky-buttons' ),
			'demo'   => __( 'Pro Demo', 'sticky-buttons' ),
		];

		echo '<div class="wpie-links">';

		$i = 1;
		foreach ( $links as $slug => $title ) {

			$link = WOWP_Plugin::info( $slug );
			if ( empty( $link ) ) {
				continue;
			}

			if ( $i % 3 === 0 ) {
				echo '<span class="wpie-links-divider">|</span>';
			}

			echo '<a href="' . esc_url( $link ) . '" class="wowp-link-' . esc_attr( $slug ) . '" target="_blank">' . esc_html( $title ) . '</a>';

			$i ++;
		}

		echo '</div>';
	}

	public function save_settings($request) {

		$param = ! empty( $request ) ? map_deep( wp_unslash( $request ), 'sanitize_text_field' ) : [];

		if ( isset( $request['menu_1']['item_tooltip'] ) ) {
			$param['menu_1']['item_tooltip'] = map_deep( $request['menu_1']['item_tooltip'], array(
				$this,
				'sanitize_tooltip'
			) );
		}

		if ( isset( $request['menu_1']['item_text'] ) ) {
			$param['menu_1']['item_text'] = map_deep( $request['menu_1']['item_text'], [
				$this,
				'sanitize_text'
			] );
		}

		if ( isset( $request['menu_1']['item_custom_text'] ) ) {
			$param['menu_1']['item_custom_text'] = map_deep( $request['menu_1']['item_custom_text'], [
				$this,
				'sanitize_tooltip'
			] );
		}

		return $param;

	}

	public function sanitize_text( $text ): string {
		return wp_kses_post( wp_encode_emoji( wp_unslash( $text ) ) );
	}

	public function sanitize_tooltip( $text ): string {
		return sanitize_text_field( wp_encode_emoji(wp_unslash( $text ) ));
	}


	public function load_assets(): void {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'wp-tinymce' );
		wp_enqueue_editor();
		wp_enqueue_media();
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );

		wp_enqueue_script( 'jquery-ui-sortable' );

//		wp_enqueue_script( 'code-editor' );
//		wp_enqueue_style( 'code-editor' );
//		wp_enqueue_script( 'htmlhint' );
//		wp_enqueue_script( 'csslint' );



		// include fonticonpicker styles & scripts
		$url_assets        = WOWP_Plugin::url() . 'vendors/';
		$slug              = WOWP_Plugin::SLUG;
		$version = WOWP_Plugin::info( 'version' );

		wp_enqueue_style( $slug. '-fontawesome', WOWP_Plugin::url() . 'vendors/fontawesome/css/all.min.css', [], '6.7.1' );

		$fonticonpicker_js = $url_assets . 'fonticonpicker/js/jquery.fonticonpicker.js';
		wp_enqueue_script( $slug . '-fonticonpicker', $fonticonpicker_js, array( 'jquery' ), '3.1.1', true );

		$fonticonpicker_css = $url_assets . 'fonticonpicker/css/base/jquery.fonticonpicker.css';
		wp_enqueue_style( $slug . '-fonticonpicker', $fonticonpicker_css, null, '3.1.1'  );

		$fonticonpicker_dark_css = $url_assets . 'fonticonpicker/css/themes/dark-grey-theme/jquery.fonticonpicker.darkgrey.css';
		wp_enqueue_style( $slug . '-fonticonpicker-darkgrey', $fonticonpicker_dark_css, null, '3.1.1' );

		$arg = [
			'plugin_url' => WOWP_Plugin::url(),
		];

		wp_localize_script( 'wp-tinymce', 'notification_obj', $arg );
	}


}