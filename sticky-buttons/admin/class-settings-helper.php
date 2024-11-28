<?php

/**
 * Class Settings_Helper
 *
 * This class contains helper methods for retrieving menu item types, share services,
 * and translation options.
 *
 * @package    StickyButtons
 * @subpackage Admin
 * @author     Dmytro Lobov <hey@wow-company.com>, Wow-Company
 * @copyright  2024 Dmytro Lobov
 * @license    GPL-2.0+
 */

namespace StickyButtons;

defined( 'ABSPATH' ) || exit;

class Settings_Helper {

	public static function item_type(): array {
		return [
			'link'          => __( 'Link', 'sticky-buttons' ),
			'email'         => __( 'Email', 'sticky-buttons' ),
			'telephone'     => __( 'Telephone', 'sticky-buttons' ),
			'login'         => __( 'Login', 'sticky-buttons' ),
			'logout'        => __( 'Logout', 'sticky-buttons' ),
			'lostpassword'  => __( 'Lostpassword', 'sticky-buttons' ),
			'register'      => __( 'Register', 'sticky-buttons' ),
		];
	}
}
