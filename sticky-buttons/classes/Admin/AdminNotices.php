<?php

namespace StickyButtons\Admin;

use StickyButtons\WOWP_Plugin;

defined( 'ABSPATH' ) || exit;

class AdminNotices {


	public static function init(): void {
		add_action( 'admin_notices', [ __CLASS__, 'admin_notice' ] );
	}

	public static function admin_notice(): bool {

		if ( ! isset( $_GET['page'] ) ) {
			return false;
		}

		if ( $_GET['page'] !== WOWP_Plugin::SLUG ) {
			return false;
		}

		if ( ! empty( $_GET['notice'] ) && $_GET['notice'] === 'save_item' ) {
			self::save_item();
		} elseif ( ! empty( $_GET['notice'] ) && $_GET['notice'] === 'remove_item' ) {
			self::remove_item();
		}

		return true;
	}

	public static function save_item(): void {
		$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : '';

		if ( ! empty( $nonce ) && wp_verify_nonce( $nonce, 'save-item' ) ) {
			$text = __( 'Item Saved', 'sticky-buttons' );
			echo '<div class="wpie-notice notice notice-success is-dismissible">' . esc_html( $text ) . '</div>';
		}
	}

	public static function remove_item(): void {
		$text = __( 'Item Remove', 'sticky-buttons' );
		echo '<div class="wpie-notice notice notice-warning is-dismissible">' . esc_html( $text ) . '</div>';
	}

}