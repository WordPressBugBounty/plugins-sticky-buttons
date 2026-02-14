<?php

/**
 * Class Conditions
 *
 * Provides methods to check conditions for displaying item
 *
 * @package    StickyButtons
 * @subpackage Publish
 * @author     Dmytro Lobov <dev@wow-company.com>, Wow-Company
 * @copyright  2024 Dmytro Lobov
 * @license    GPL-2.0+
 */

namespace StickyButtons\Publish;

use StickyButtons\Admin\ManageCapabilities;
use StickyButtons\WOWP_Plugin;

defined( 'ABSPATH' ) || exit;

class Conditions {

	public static function init( $result ): bool {
		$param = ! empty( $result->param ) ? maybe_unserialize( $result->param ) : [];

		$check = [
			'status'         => self::status( $result->status ),
			'mode'           => self::mode( $result->mode ),
		];

		$check = apply_filters( WOWP_Plugin::PREFIX . '_conditions', $check, $param );

		if ( in_array( false, $check, true ) ) {
			return false;
		}

		return true;

	}

	private static function status( $status ): bool {
		return empty( $status );
	}

	private static function mode( $mode ): bool {
		$capability  = ManageCapabilities::get_capability();

		return empty( $mode ) || current_user_can( $capability );
	}

}
