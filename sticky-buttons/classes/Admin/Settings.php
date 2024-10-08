<?php

namespace StickyButtons\Admin;

defined( 'ABSPATH' ) || exit;

use StickyButtons\WOWP_Plugin;

class Settings {

	public static function init(): void {

		$pages   = DashboardHelper::get_files( 'settings' );
		$options = self::get_options();
		$checked = $options['setting_tab'] ?? 1;

		echo '<h3 class="wpie-tabs">';
		foreach ( $pages as $key => $page ) {
			$class = ( absint( $checked ) === $key ) ? ' selected' : '';
			echo '<label class="wpie-tab-label' . esc_attr( $class ) . '" for="setting_tab_' . absint( $key ) . '">' . esc_html( $page['name'] ) . '</label>';
		}
		echo '</h3>';

		echo '<div class="wpie-tabs-contents">';
		foreach ( $pages as $key => $page ) {
			$file = DashboardHelper::get_folder_path( 'settings' ) . '/' . $key . '.' . $page['file'] . '.php';
			echo '<input type="radio" class="wpie-tab-toggle" name="param[setting_tab]" value="' . absint( $key ) . '" id="setting_tab_' . absint( $key ) . '" ' . checked( $key, $checked, false ) . '>';
			if ( file_exists( $file ) ) {
				echo '<div class="wpie-tab-content">';
				require_once $file;
				echo '</div>';
			}
		}
		echo '</div>';

	}

	public static function save_item() {

		$verify = AdminActions::verify(WOWP_Plugin::PREFIX . '_settings');

		if ( ! $verify ) {
			return false;
		}

		if ( empty( $_POST['submit_settings'] ) ) {
			return false;
		}

		$id = isset( $_POST['tool_id'] ) ? absint( wp_unslash( $_POST['tool_id'] ) ) : 0;

		$settings = apply_filters( WOWP_Plugin::PREFIX . '_save_settings', '' );

		$removes      = [ 'wpie_buttons_settings', '_wp_http_referer', 'submit_settings' ];
		$keys_flipped = array_flip( $removes );
		$settings     = array_diff_key( $settings, $keys_flipped );

		$data    = [
			'title'  => isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash($_POST['title'] )) : '',
			'status' => isset( $_POST['status'] ) ? 1 : 0,
			'mode'   => isset( $_POST['mode'] ) ? 1 : 0,
			'tag'    => isset( $_POST['tag'] ) ? sanitize_text_field( wp_unslash($_POST['tag'] )) : '',
			'param'  => maybe_serialize( $settings ),
		];
		$formats = [
			'%s',
			'%d',
			'%d',
			'%s',
			'%s'
		];

		if ( empty( $id ) ) {
			$id_item = DBManager::insert( $data, $formats );
		} else {
			$where = [
				'id' => absint( $id ),
			];
			DBManager::update( $data, $where, $formats );
			$id_item = $id;
		}

		wp_safe_redirect( Link::save_item( $id_item ) );
		exit;

	}

	public static function deactivate_item( $id = 0 ): void {

		$verify = AdminActions::verify(WOWP_Plugin::PREFIX . '_deactivate_item');

		if ( ! $verify ) {
			return;
		}

		$id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : $id;

		if ( ! empty( $id ) ) {
			DBManager::update( [ 'status' => '1' ], [ 'ID' => $id ], [ '%d' ] );
		}

	}


	public static function activate_item( $id = 0 ): void {
		$verify = AdminActions::verify(WOWP_Plugin::PREFIX . '_activate_item');

		if ( ! $verify ) {
			return;
		}

		$id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : $id;

		if ( ! empty( $id ) ) {
			DBManager::update( [ 'status' => '' ], [ 'ID' => $id ], [ '%d' ] );
		}

	}

	public static function deactivate_mode( $id = 0 ): void {
		$verify = AdminActions::verify(WOWP_Plugin::PREFIX . '_deactivate_mode');

		if ( ! $verify ) {
			return;
		}

		$id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : $id;

		if ( ! empty( $id ) ) {
			DBManager::update( [ 'mode' => '' ], [ 'ID' => $id ], [ '%d' ] );
		}

	}

	public static function activate_mode( $id = 0 ): void {
		$verify = AdminActions::verify(WOWP_Plugin::PREFIX . '_activate_mode');

		if ( ! $verify ) {
			return;
		}
		$id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : $id;

		if ( ! empty( $id ) ) {
			DBManager::update( [ 'mode' => '1' ], [ 'ID' => $id ], [ '%d' ] );
		}
	}

	public static function get_options() {

		$id = isset( $_REQUEST['id'] ) ? absint( $_REQUEST['id'] ) : 0;

		if ( empty( $id ) ) {
			return false;
		}

		$action = isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : 'update';
		$result = DBManager::get_data_by_id( $id );

		if ( empty( $result ) || empty( $result->param ) ) {
			return false;
		}

		$param = maybe_unserialize( $result->param );
		$param['title']  = $result->title;
		$param['status'] = $result->status;
		$param['mode']   = $result->mode;
		$param['tag']    = $result->tag;
		if ( ! empty( $param ) ) {
			$param['id'] = $id;
		}

		if ( $action === 'duplicate' ) {
			$param['id']    = '';
			$param['title'] = '';
		}

		return $param;
	}

	public static function option( $name, $option ) {
		return $options[ $name ] ?? '';
	}

}