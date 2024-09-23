<?php

namespace StickyButtons\Admin;

use StickyButtons\WOWP_Plugin;

defined( 'ABSPATH' ) || exit;

class AdminActions {

	public static function init(): void {
		add_action( 'admin_init', [ __CLASS__, 'actions' ] );
	}

	public static function actions(): bool {
		$name = self::check_name();

		if ( empty( $name ) ) {
			return false;
		}
		$verify = self::verify( $name );

		if ( ! $verify ) {
			return false;
		}

		if ( strpos( $name, '_export_data' ) !== false ) {
			ImporterExporter::export_data();
		} elseif ( strpos( $name, '_export_item' ) !== false ) {
			ImporterExporter::export_item();
		} elseif ( strpos( $name, '_import_data' ) !== false ) {
			ImporterExporter::import_data();
		} elseif ( strpos( $name, '_remove_item' ) !== false ) {
			DBManager::remove_item();
		} elseif ( strpos( $name, '_settings' ) !== false ) {
			Settings::save_item();
		} elseif ( strpos( $name, '_activate_item' ) !== false ) {
			Settings::activate_item();
		} elseif ( strpos( $name, '_deactivate_item' ) !== false ) {
			Settings::deactivate_item();
		} elseif ( strpos( $name, '_activate_mode' ) !== false ) {
			Settings::activate_mode();
		} elseif ( strpos( $name, '_deactivate_mode' ) !== false ) {
			Settings::deactivate_mode();
		} elseif ( strpos( $name, '_capabilities' ) !== false ) {
			ManageCapabilities::save();
		}

		return true;
	}

	public static function verify( $name ): bool {
		$nonce_action = WOWP_Plugin::PREFIX . '_nonce';
		$nonce        = isset( $_REQUEST[ $name ] ) ? sanitize_text_field( wp_unslash( $_REQUEST[ $name ] ) ) : '';

		return ( ! empty( $nonce ) ) && ( wp_verify_nonce( $nonce, $nonce_action ) || current_user_can( 'manage_options' ) );
	}

	private static function check_name(): string {
		$names = [
			WOWP_Plugin::PREFIX . '_import_data',
			WOWP_Plugin::PREFIX . '_export_data',
			WOWP_Plugin::PREFIX . '_export_item',
			WOWP_Plugin::PREFIX . '_remove_item',
			WOWP_Plugin::PREFIX . '_settings',
			WOWP_Plugin::PREFIX . '_activate_item',
			WOWP_Plugin::PREFIX . '_deactivate_item',
			WOWP_Plugin::PREFIX . '_activate_mode',
			WOWP_Plugin::PREFIX . '_deactivate_mode',
			WOWP_Plugin::PREFIX . '_capabilities',
		];

		foreach ( $names as $name ) {
			if ( isset( $_REQUEST[ $name ] ) ) {
				return $name;
			}
		}

		return '';
	}


}