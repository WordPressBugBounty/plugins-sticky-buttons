<?php

namespace StickyButtons\Admin;

use StickyButtons\Update\UpdateDB;
use StickyButtons\WOWP_Plugin;

class Demo {

	public static function init() {
		add_action( WOWP_Plugin::PREFIX . '_admin_after_button', [ __CLASS__, 'demo_button' ] );
		add_action( 'wp_ajax_' . WOWP_Plugin::PREFIX . '_upload_demo', [ __CLASS__, 'upload_demo' ] );
	}

	public static function demo_button(): void {
		$demo = [
			'bottom-navigation' => [
				'name' => __( 'Bottom Navigation', 'sticky-buttons' ),
				'link' => 'https://lite.wow-estore.com/sticky-buttons/',
			],
			'navigation-menu'    => [
				'name' => __( 'Navigation Menu', 'sticky-buttons' ),
				'link' => 'https://lite.wow-estore.com/sticky-buttons/',
			],
			'social-media-menu'      => [
				'name' => __( 'Social Media Menu', 'sticky-buttons' ),
				'link' => 'https://lite.wow-estore.com/sticky-buttons/',
			],
			'simple-menu'   => [
				'name' => __( 'Simple Menu', 'sticky-buttons' ),
				'link' => 'https://lite.wow-estore.com/sticky-buttons/',
			],

			'sub-menus_pro' => [
				'name' => __( 'Sub menus', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/sub-menus/',
			],

			'share-menu_pro' => [
				'name' => __( 'Share Menu', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/share/',
			],

			'share-text_pro' => [
				'name' => __( 'Share Text', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/text-share-copy',
			],

			'icon-with-text_pro' => [
				'name' => __( 'Icon with Text', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/icon-with-text',
			],

			'reactions_pro' => [
				'name' => __( 'Reactions', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/reactions',
			],

			'favorite_pro' => [
				'name' => __( 'Add to Favorite', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/favorites',
			],

			'translate_pro' => [
				'name' => __( 'Translate', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/translate/',
			],

			'actions_pro' => [
				'name' => __( 'Actions', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/actions/',
			],

			'font-size_pro' => [
				'name' => __( 'Font Size', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/font-size',
			],

			'icon-animation_pro' => [
				'name' => __( 'Icon animations', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/icon-animations/',
			],

			'image-actions_pro' => [
				'name' => __( 'Image Actions', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/image-actions',
			],

			'media-control_pro' => [
				'name' => __( 'Media Control', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/media-control',
			],

            'scrolling_pro' => [
				'name' => __( 'Scrolling', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/scrolling/',
			],

            'scrollspy_pro' => [
				'name' => __( 'ScrollSpy', 'sticky-buttons' ),
				'link' => 'https://demo.wow-estore.com/sticky-buttons-pro/scrollspy/',
			],
		];


		?>

        <button type="button" class="button" onclick="window.demoUpload.showModal()">
			<?php esc_html_e( 'Load Example', 'sticky-buttons' ); ?>
        </button>

        <dialog id="demoUpload" class="wpie-dialog">
            <button type="button" class="wpie-dialog-close" onclick="window.demoUpload.close()">
                <span class="wpie-icon wpie_icon-xmark"></span>
            </button>
            <table>
                <thead>
                <tr>
                    <th>
						<?php esc_html_e( 'Name', 'sticky-buttons' ); ?>
                    </th>
                    <th>
						<?php esc_html_e( 'Preview Link', 'sticky-buttons' ); ?>
                    </th>
                    <th>
						<?php esc_html_e( 'Action', 'sticky-buttons' ); ?>
                    </th>
                </tr>
                </thead>
                <tbody>
				<?php foreach ( $demo as $file => $item ) : ?>
                    <tr>
                        <td><?php echo esc_html( $item['name'] ); ?></td>
                        <td><a href="<?php echo esc_url( $item['link'] ); ?>"
                               target="_blank"><?php esc_html_e( 'Preview', 'sticky-buttons' ); ?></a></td>
                        <td>
							<?php if ( strpos( $file, '_pro' ) === false || class_exists( '\StickyButtons\WOWP_PRO' ) )  : ?>
                                <button class="wpie-download"
                                        data-menu="<?php echo esc_attr( strtolower( $file ) ); ?>">
									<?php esc_html_e( 'Download', 'sticky-buttons' ); ?>
                                </button>
							<?php else: ?>
                                <a href="<?php echo esc_url( WOWP_Plugin::info( 'pro' ) ); ?>"
                                   class="wpie-pro"><?php esc_html_e( 'Available in Pro', 'sticky-buttons' ); ?></a>
							<?php endif; ?>
                        </td>
                    </tr>
				<?php endforeach; ?>
                </tbody>
            </table>
        </dialog>

		<?php
	}

	public static function upload_demo(): void {
		$menu = sanitize_key( $_POST['menu'] ?? '' );
		if ( strpos( $menu, '_pro' ) !== false ) {
			$demo_path = WOWP_Plugin::dir() . 'includes/pro/demo/' . $menu . '.json';
		} else {
			$demo_path = WOWP_Plugin::dir() . 'admin/demo/' . $menu . '.json';
		}

		$capability  = ManageCapabilities::get_capability();

		if ( ! current_user_can( $capability ) ) {
			wp_send_json_error( [ 'message' => 'Permission denied' ], 403 );
		}

		if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['security'] ) ), WOWP_Plugin::PREFIX . '_settings' ) ) {
			wp_send_json_error( [ 'message' => 'Invalid nonce' ], 400 );
		}

		if ( file_exists( $demo_path ) ) {
			$settings = wp_json_file_decode( $demo_path );
			$columns  = DBManager::get_columns();

			foreach ( $settings as $key => $val ) {
				$data    = [];
				$formats = [];

				foreach ( $columns as $column ) {
					$name = $column->Field;

					$data[ $name ] = ! empty( $val->$name ) ? $val->$name : '';

					if ( $name === 'id' || $name === 'status' || $name === 'mode' ) {
						$formats[] = '%d';
					} else {
						$formats[] = '%s';
					}
				}

				$index = array_search( 'id', array_keys( $data ), true );
				unset( $data['id'], $formats[ $index ] );
				DBManager::insert( $data, $formats );
			}
		}

		wp_send_json_success( [ 'path' => $demo_path ] );
	}

}