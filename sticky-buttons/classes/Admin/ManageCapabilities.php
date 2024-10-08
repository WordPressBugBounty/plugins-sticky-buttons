<?php

namespace StickyButtons\Admin;

use StickyButtons\WOWP_Plugin;
use WP_Roles;

defined( 'ABSPATH' ) || exit;

class ManageCapabilities {

	public static function form(): void {
		$current = self::get_capability();
		?>

        <form method="post">
            <div class="wpie-fieldset">
                <div class="wpie-fields">
                    <div class="wpie-field" data-field-box="zindex">
                        <div class="wpie-field__title">Capabilities</div>
                        <label class="wpie-field__label">
                            <span class="screen-reader-text">Capabilities</span>
                            <select name="plugin_capability">
								<?php foreach ( self::capabilities() as $capability ) {
									echo '<option value="' . esc_attr( $capability ) . '"' . selected( $capability, $current, 0 ) . '>' . esc_attr( $capability ) . '</option>';
								} ?>
                            </select>
                        </label>

                    </div>

                    <div class="wpie-action__btn">
						<?php
						submit_button( __( 'Save Change', 'side-menu-lite' ), 'large', 'submit', false );
						wp_nonce_field( WOWP_Plugin::PREFIX . '_nonce', WOWP_Plugin::PREFIX . '_capabilities' ); ?>
                    </div>
                </div>
            </div>
        </form>

		<?php
	}

	private static function capabilities(): array {
		global $wp_roles;

		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}

		$capabilities = array();

		foreach ( $wp_roles->roles as $role ) {
			foreach ( $role['capabilities'] as $cap => $enabled ) {
				if ( $enabled ) {
					$capabilities[] = $cap;
				}
			}
		}

		$capabilities = array_unique( $capabilities );
		sort( $capabilities );

		return $capabilities;

	}

	public static function save(): bool {
		$verify = AdminActions::verify( WOWP_Plugin::PREFIX . '_capabilities' );

		if ( ! $verify ) {
			return false;
		}

		if ( ! isset( $_POST['plugin_capability'] ) ) {
			return false;
		}

		$capability = sanitize_text_field( wp_unslash( $_POST['plugin_capability'] ) );

		update_option( WOWP_Plugin::PREFIX . '_plugin_capabilities', $capability );

		return true;
	}

	public static function get_capability() {
		return get_option( WOWP_Plugin::PREFIX . '_plugin_capabilities', 'manage_options' );
	}
}