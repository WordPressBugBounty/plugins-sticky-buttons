<?php

/**
 * Class Display
 *
 * This class is responsible for displaying the item based on specific conditions.
 *
 * @package    StickyButtons
 * @subpackage Publish
 * @author     Dmytro Lobov <hey@wow-company.com>, Wow-Company
 * @copyright  2024 Dmytro Lobov
 * @license    GPL-2.0+
 *
 */

namespace StickyButtons\Publish;

defined( 'ABSPATH' ) || exit;

class Display {


	public static function init( $id, $param ): bool {
		if ( self::can_abort_early( $id, $param ) ) {
			return false;
		}

		return self::check_shows( $param['show'], $param );
	}

	private static function can_abort_early( $id, $param ): bool {
		return empty( $param ) || ! is_array( $param ) || empty( absint( $id ) );
	}

	private static function check_shows( $showParams, $param ): bool {

		foreach ( $showParams as $i => $show ) {

			if ( self::is_match( $show, $i, $param ) ) {
				return true;
			}
		}

		return false;
	}

	private static function is_match( $show, $i, $param ): bool {

		$cases = [
			'everywhere' => 'check_everywhere',
		];

		if ( ! isset( $cases[ $show ] ) ) {
			return false;
		}

		$function = $cases[ $show ];

		return self::$function( $i, $param );

	}

	private static function check_everywhere(): bool {
		return true;
	}

}

