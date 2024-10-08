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

defined( 'ABSPATH' ) || exit;

class WOWP_Admin {
	public function __construct() {
		Dashboard::init();
		AdminActions::init();
		$this->includes();

		add_action( WOWP_Plugin::PREFIX . '_admin_header_links', [ $this, 'plugin_links' ] );
		add_filter( WOWP_Plugin::PREFIX . '_save_settings', [ $this, 'save_settings' ] );
		add_action( WOWP_Plugin::PREFIX . '_admin_load_assets', [ $this, 'load_assets' ] );

	}

	public function includes(): void {
		require_once plugin_dir_path( __FILE__ ) . 'class-settings-helper.php';
	}

	public function plugin_links(): void {
		?>
        <div class="wpie-links">
            <a href="<?php echo esc_url( WOWP_Plugin::info( 'pro' ) ); ?>" target="_blank">PRO Plugin</a>
            <a href="<?php echo esc_url( WOWP_Plugin::info( 'rating' ) ); ?>" target="_blank" class="wpie-color-orange">Rating</a>
        </div>
		<?php
	}

	public function save_settings() {

		$param = ! empty( $_POST['param'] ) ? map_deep( wp_unslash($_POST['param']), 'sanitize_text_field' ) : [];

		if ( isset( $_POST['param']['menu_1']['item_tooltip'] ) ) {
			$param['menu_1']['item_tooltip'] = map_deep( wp_unslash($_POST['param']['menu_1']['item_tooltip']), array(
				$this,
				'sanitize_tooltip'
			) );
		}

		if ( isset( $_POST['param']['menu_1']['item_text'] ) ) {
			$param['menu_1']['item_text'] = map_deep( wp_unslash($_POST['param']['menu_1']['item_text']), [
				$this,
				'sanitize_text'
			] );
		}

		if ( isset( $_POST['param']['menu_1']['item_custom_text'] ) ) {
			$param['menu_1']['item_custom_text'] = map_deep( wp_unslash($_POST['param']['menu_1']['item_custom_text']), [
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

		wp_enqueue_script( 'code-editor' );
		wp_enqueue_style( 'code-editor' );
		wp_enqueue_script( 'htmlhint' );
		wp_enqueue_script( 'csslint' );

		wp_enqueue_style( 'notification-fontawesome', WOWP_Plugin::url() . 'vendors/fontawesome/css/all.min.css', [], '6.6' );

		// include fonticonpicker styles & scripts
		$url_assets        = WOWP_Plugin::url() . 'vendors/';
		$slug              = 'notification';
		$fonticonpicker_js = $url_assets . 'fonticonpicker/fonticonpicker.min.js';
		wp_enqueue_script( $slug . '-fonticonpicker', $fonticonpicker_js, array( 'jquery' ), '2.0', true );

		$fonticonpicker_css = $url_assets . 'fonticonpicker/css/fonticonpicker.min.css';
		wp_enqueue_style( $slug . '-fonticonpicker', $fonticonpicker_css );

		$fonticonpicker_dark_css = $url_assets . 'fonticonpicker/fonticonpicker.darkgrey.min.css';
		wp_enqueue_style( $slug . '-fonticonpicker-darkgrey', $fonticonpicker_dark_css );

		$arg = [
			'plugin_url' => WOWP_Plugin::url(),
		];

		wp_localize_script( 'wp-tinymce', 'notification_obj', $arg );
	}


}