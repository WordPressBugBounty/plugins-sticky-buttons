<?php

/**
 * Class UpdateDB
 *
 * Contains methods for updating the database structure and data
 *
 * @package    StickyButtons
 * @subpackage Update
 * @author     Dmytro Lobov <hey@wow-company.com>, Wow-Company
 * @copyright  2024 Dmytro Lobov
 * @license    GPL-2.0+
 *
 */

namespace StickyButtons\Update;

use StickyButtons\Admin\DBManager;
use StickyButtons\Settings_Helper;
use StickyButtons\WOWP_Plugin;

class UpdateDB {

	public static function init(): void {
		$current_db_version = get_option( WOWP_Plugin::PREFIX . '_db_version' );

		if ( $current_db_version && version_compare( $current_db_version, '4.0', '>=' ) ) {
			return;
		}

		self::start_update();

		update_option( WOWP_Plugin::PREFIX . '_db_version', '8.0' );
	}

	public static function start_update(): void {
		self::update_database();
		self::update_options();
		self::update_fields();
	}

	public static function update_database(): void {

		global $wpdb;
		$table           = $wpdb->prefix . WOWP_Plugin::PREFIX;
		$charset_collate = $wpdb->get_charset_collate();

		$columns = "
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			title VARCHAR(200) DEFAULT '' NOT NULL,
			param longtext DEFAULT '' NOT NULL,
			status boolean DEFAULT 0 NOT NULL,
			mode boolean DEFAULT 0 NOT NULL,
			tag text DEFAULT '' NOT NULL,
			PRIMARY KEY  (id)
			";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$sql = "CREATE TABLE $table ($columns) $charset_collate;";
		dbDelta( $sql );
	}

	public static function update_options(): void {

		$license = get_option( 'wow_license_key_sbtn' );
		$status  = get_option( 'wow_license_status_sbtn' );
		if ( $license !== false ) {
			update_option( 'wow_license_key_' . WOWP_Plugin::PREFIX, $license );
		}

		if ( $status !== false ) {
			update_option( 'wow_license_status_' . WOWP_Plugin::PREFIX, $status );
		}
	}

	public static function update_fields(): void {
		$results = DBManager::get_all_data();

		if ( empty( $results ) || ! is_array( $results ) ) {
			return;
		}
		foreach ( $results as $result ) {
			$param     = maybe_unserialize( $result->param );
			$status    = ! empty( $param['status'] ) ? 1 : 0;
			$test_mode = ! empty( $param['test_mode'] ) ? 1 : 0;

			$param = self::update_param( $param );

			$data = [
				'param'  => maybe_serialize( $param ),
				'status' => absint( $status ),
				'mode'   => absint( $test_mode ),
				'tag'    => '',
			];

			$where = [ 'id' => $result->id ];

			$data_formats = [ '%s', '%d', '%d', '%s' ];

			DBManager::update( $data, $where, $data_formats );

		}
	}

	public static function update_param( $param ) {
		if ( ! isset( $param['language_on'] ) ) {
			$param['language_on'] = ! empty( $param['depending_language'] ) ? 1 : 0;
		}

		if ( ! isset( $param['fontawesome'] ) ) {
			$param['fontawesome'] = ! empty( $param['disable_fontawesome'] ) ? 1 : 0;
		}

		// Browsers
		if ( ! isset( $param['browser_opera'] ) ) {
			$param['browser_opera'] = $param['br_opera'] ?? 0;
		}
		if ( ! isset( $param['browser_edge'] ) ) {
			$param['browser_edge'] = $param['br_edge'] ?? 0;
		}
		if ( ! isset( $param['browser_chrome'] ) ) {
			$param['browser_chrome'] = $param['br_chrome'] ?? 0;
		}
		if ( ! isset( $param['browser_safari'] ) ) {
			$param['browser_safari'] = $param['br_safari'] ?? 0;
		}
		if ( ! isset( $param['browser_firefox'] ) ) {
			$param['browser_firefox'] = $param['br_firefox'] ?? 0;
		}
		if ( ! isset( $param['browser_ie'] ) ) {
			$param['browser_ie'] = $param['br_ie'] ?? 0;
		}
		if ( ! isset( $param['browser_other'] ) ) {
			$param['browser_other'] = $param['br_other'] ?? 0;
		}

		// Schedule
		if ( ! is_array( $param['weekday'] ) ) {
			$week_old       = $param['weekday'] ?? '';
			$time_start_old = $param['time_start'] ?? '';
			$time_end_old   = $param['time_end'] ?? '';
			$dates_old      = ! empty( $param['set_dates'] ) ? 1 : 0;
			$date_start_old = $param['date_start'] ?? '';
			$date_end_old   = $param['date_end'] ?? '';

			$param['weekday']    = [];
			$param['time_start'] = [];
			$param['time_end']   = [];
			$param['dates']      = [];
			$param['date_start'] = [];
			$param['date_end']   = [];

			$param['weekday'][0]    = $week_old;
			$param['time_start'][0] = $time_start_old;
			$param['time_end'][0]   = $time_end_old;
			$param['dates'][0]      = $dates_old;
			$param['date_start'][0] = $date_start_old;
			$param['date_end'][0]   = $date_end_old;
		}
		if ( ! isset( $param['gap'] ) && ! empty( $param['space'] ) ) {
			$param['gap'] = 2;
			$param['m_block'] = 2;
			$param['m_inline'] = 2;
		}

		// Users
		if ( ! isset( $param['users'] ) ) {
			$param['users'] = $param['item_user'] ?? 1;
			if ( 2 === absint( $param['users'] ) ) {
				$editable_role = array_reverse( get_editable_roles() );
				$user_role     = $param['user_role'] ?? 'all';

				foreach ( $editable_role as $role => $details ) {
					if ( $user_role === 'all' ) {
						$param[ 'user_' . $role ] = 1;
						continue;
					}
					if ( $user_role === $role ) {
						$param[ 'user_' . $role ] = 1;
					}
				}
			}
		}

		// Show
		if ( ! is_array( $param['show'] ) ) {
			$show_old = ! empty( $param['show'] ) ? $param['show'] : 'everywhere';

			$param['show']      = [];
			$param['operator']  = [];
			$param['page_type'] = [];
			$param['ids']       = [];

			$param['show'][0]      = 'shortcode';
			$param['operator'][0]  = '1';
			$param['page_type'][0] = 'is_front_page';
			$param['ids'][0]       = ! empty( $param['id_post'] ) ? $param['id_post'] : '';

			switch ( $show_old ) {
				case 'all':
					$param['show'][0] = 'everywhere';
					break;
				case 'onlypost':
					$param['show'][0] = 'post_all';
					break;
				case 'posts':
					$param['show'][0] = 'post_selected';
					break;
				case 'postsincat':
					$param['show'][0] = 'post_category';
					break;
				case 'expost':
					$param['show'][0]     = 'post_selected';
					$param['operator'][0] = 0;
					break;
				case 'onlypage':
					$param['show'][0] = 'page_all';
					break;
				case 'pages':
					$param['show'][0] = 'page_selected';
					break;
				case 'expage':
					$param['show'][0]     = 'page_selected';
					$param['operator'][0] = 0;
					break;
				case 'homepage':
					$param['show'][0]      = 'page_type';
					$param['page_type'][0] = 'is_front_page';
					break;
				case 'searchpage':
					$param['show'][0]      = 'page_type';
					$param['page_type'][0] = 'is_search';
					break;
				case 'archivepage':
					$param['show'][0]      = 'page_type';
					$param['page_type'][0] = 'is_archive';
					break;
				case 'error_page':
					$param['show'][0]      = 'page_type';
					$param['page_type'][0] = 'is_404';
					break;
				case 'post_type':
					$custom_post      = $param['post_types'] ?? '';
					$param['show'][0] = 'custom_post_all_' . $custom_post;
					break;
				case 'taxonomy':
					$taxonomy         = $param['taxonomy'] ?? '';
					$param['show'][0] = 'custom_post_tax_|' . $taxonomy;
					break;
			}
		}

		return $param;
	}

}