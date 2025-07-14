<?php

/**
 * Class UpdateDB
 *
 * Contains methods for updating the database structure and data
 *
 * @package    StickyButtons
 * @subpackage Update
 * @author     Dmytro Lobov <dev@wow-company.com>, Wow-Company
 * @copyright  2024 Dmytro Lobov
 * @license    GPL-2.0+
 *
 */

namespace StickyButtons\Update;

use StickyButtons\Admin\DBManager;
use StickyButtons\WOWP_Plugin;

class UpdateDB {

	public static function init(): void {
		$current_db_version = get_site_option( WOWP_Plugin::PREFIX . '_db_version' );

		if ( $current_db_version && version_compare( $current_db_version, '7.0', '>=' ) ) {
			return;
		}

		self::start_update();

		update_site_option( WOWP_Plugin::PREFIX . '_db_version', '7.0' );
	}

	public static function start_update(): void {
		self::update_fields();
	}

	public static function update_fields(): void {
		$results = DBManager::get_all_data();

		if ( empty( $results ) || ! is_array( $results ) ) {
			return;
		}
		foreach ( $results as $result ) {
			$param = maybe_unserialize( $result->param );

			$param = self::update_param( $param );

			$data = [
				'param' => maybe_serialize( $param ),
			];

			$where = [ 'id' => $result->id ];

			$data_formats = [ '%s' ];

			DBManager::update( $data, $where, $data_formats );

		}
	}

	public static function update_param( $param ) {
		$count = ( ! empty( $param['menu_1']['item_type'] ) ) ? count( $param['menu_1']['item_type'] ) : '0';
		if ( $count > 0 ) {
			for ( $i = 0; $i < $count; $i ++ ) {

				if ( $param['menu_1']['item_type'][ $i ] === 'popup' && ! isset( $param['menu_1']['popupcontent'][ $i ] ) && isset( $param['popupcontent'] ) ) {
					$param['menu_1']['popupcontent'][ $i ] = $param['popupcontent'];
					$param['menu_1']['popuptitle'][ $i ]   = $param['popuptitle'];
				}

				if ( ! empty( $param['menu_1']['item_custom'][ $i ] ) && ! isset( $param['menu_1']['icon_type'][ $i ] ) ) {
					$param['menu_1']['icon_type'][ $i ] = 'image';
				}

				if ( ! empty( $param['menu_1']['item_custom_text_check'][ $i ] ) && ! isset( $param['menu_1']['icon_type'][ $i ] ) ) {
					$param['menu_1']['icon_type'][ $i ] = 'text';
				}

				if ( isset( $param['menu_1']['item_icon_anomate'][ $i ] ) ) {
					$param['menu_1']['item_icon_anomate'][ $i ] = str_replace( "fa-", "-", $param['menu_1']['item_icon_anomate'][ $i ] );
				}
			}
		}

		if ( ! empty( $param['showAfterPosition'] ) && ! isset( $param['scroll_action'] ) ) {
			$param['scroll_action'] = 'show';
			$param['scroll']        = $param['showAfterPosition'];
		}

		if ( ! empty( $param['hideAfterPosition'] ) && ! isset( $param['scroll_action'] ) ) {
			$param['scroll_action'] = 'hide';
			$param['scroll']        = $param['hideAfterPosition'];
		}

		if ( isset( $param['windowColor'] ) && ! isset( $param['popup_head_bg'] ) ) {
			if ( $param['windowColor'] === 'black' ) {
				$param['popup_head_bg'] = '#2a2a2a';
			} elseif ( $param['windowColor'] === 'red' ) {
				$param['popup_head_bg'] = '#F23D3D';
			} elseif ( $param['windowColor'] === 'yellow' ) {
				$param['popup_head_bg'] = '#FFBD22';
			} elseif ( $param['windowColor'] === 'blue' ) {
				$param['popup_head_bg'] = '#4090FF';
			}
		}

		return $param;
	}

}