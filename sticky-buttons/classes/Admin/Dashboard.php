<?php
/**
 * Class Dashboard
 *
 * Handles the dashboard functionality of the plugin
 *
 * @package StickyButtons\Admin
 */

namespace StickyButtons\Admin;

use /**
 * Class WOWP_Plugin
 *
 * This class represents a WordPress plugin that adds custom buttons to the WordPress editor.
 */
	StickyButtons\WOWP_Plugin;

/**
 * Class Dashboard
 */
class Dashboard {

	public static function init() {
		add_filter( 'plugin_action_links', [ __CLASS__, 'settings_link' ], 10, 2 );
		add_filter( 'admin_footer_text', [ __CLASS__, 'footer_text' ] );
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'admin_assets' ] );
		add_action( 'admin_menu', [ __CLASS__, 'admin_page' ] );
		AdminNotices::init();
	}

	public static function settings_link( $links, $file ) {
		if ( false === strpos( $file, WOWP_Plugin::basename() ) ) {
			return $links;
		}
		$link          = admin_url( 'admin.php?page=' . WOWP_Plugin::SLUG );
		$text          = esc_attr__( 'Settings', 'side-menu-lite' );
		$settings_link = '<a href="' . esc_url( $link ) . '">' . esc_attr( $text ) . '</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}

	public static function footer_text( $footer_text ) {
		global $pagenow;

		$page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

		if ( $pagenow === 'admin.php' && ( ! empty( $page ) && $page === WOWP_Plugin::SLUG ) ) {
			$text = sprintf(
			/* translators: 1: Rating link (URL), 2: Plugin name */
				__( 'Thank you for using <b>%2$s</b>! Please <a href="%1$s" target="_blank">rate us</a>', 'side-menu-lite' ),
				esc_url( WOWP_Plugin::info( 'url' ) ),
				esc_attr( WOWP_Plugin::info( 'name' ) )
			);

			return str_replace( '</span>', '', $footer_text ) . ' | ' . $text . '</span>';
		}

		return $footer_text;
	}

	public static function admin_assets( $hook ): void {

		$page = 'wow-plugins_page_' . WOWP_Plugin::SLUG;
		if ( $page !== $hook ) {
			return;
		}
		do_action( WOWP_Plugin::PREFIX . '_admin_load_assets' );

		$slug       = WOWP_Plugin::SLUG;
		$version    = WOWP_Plugin::info( 'version' );
		$assets_url = WOWP_Plugin::url() . 'admin/assets/';

		$styles = DashboardHelper::get_files( 'assets/css' );

		if ( ! empty( $styles ) ) {
			foreach ( $styles as $key => $style ) {
				$name = $style['file'];
				$file = $key . '.' . $name;
				wp_enqueue_style( $slug . '-admin-' . $name, $assets_url . 'css/' . $file . '.css', null, $version );
			}
		}

		$scripts = DashboardHelper::get_files( 'assets/js' );
		if ( ! empty( $scripts ) ) {
			foreach ( $scripts as $key => $script ) {
				$name = $script['file'];
				$file = $key . '.' . $name;
				wp_enqueue_script( $slug . '-admin-' . $name, $assets_url . 'js/' . $file . '.js', [ 'jquery' ], $version, true );
			}
		}


	}

	public static function admin_page() {
		$page_title  = WOWP_Plugin::info( 'name' );
		$menu_title  = WOWP_Plugin::info( 'menu_title' );
		$capability  = ManageCapabilities::get_capability();
		$parent_slug = 'wow-company';
		add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, WOWP_Plugin::SLUG, [
			__CLASS__,
			'dashboard'
		] );
	}

	public static function dashboard() {
		self::header();
		echo '<div class="wrap wpie-wrap">';
		self::menu();
		self::include_pages();
		echo '</div>';
	}

	public static function header() {
		$logo_url = self::logo_url();
		?>
        <div class="wpie-header-wrapper">
            <div class="wpie-header-border"></div>
            <div class="wpie-header">
                <div class="wpie-header__container">
					<?php if ( ! empty( $logo_url ) ): ?>
                        <div class="wpie-logo">
                            <img src="<?php echo esc_url( $logo_url ); ?>"
                                 alt="<?php echo esc_attr( WOWP_Plugin::info( 'name' ) ); ?> logo">
                        </div>
					<?php endif; ?>
                    <h1><?php echo esc_html( WOWP_Plugin::info( 'name' ) ); ?> <sup
                                class="wpie-version"><?php echo esc_html( WOWP_Plugin::info( 'version' ) ); ?></sup>
                    </h1>
                    <a href="<?php echo esc_url( Link::add_new_item() ); ?>"
                       class="button button-primary"><?php esc_html_e( 'Add New', 'side-menu-lite' ); ?>
                    </a>
					<?php do_action( WOWP_Plugin::PREFIX . '_admin_header_links' ); ?>
                </div>
            </div>
        </div>
		<?php

	}


	public static function logo_url(): string {
		$logo_url = WOWP_Plugin::url() . 'admin/assets/img/plugin-logo.png';
		if ( filter_var( $logo_url, FILTER_VALIDATE_URL ) !== false ) {
			return $logo_url;
		}

		return '';
	}

	public static function menu() {
		$pages = DashboardHelper::get_files( 'pages' );

		$current_page = self::get_current_page();

		$action = ( isset( $_REQUEST["action"] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST["action"] ) ) : '';

		echo '<h2 class="nav-tab-wrapper wpie-nav-tab-wrapper">';
		foreach ( $pages as $key => $page ) {
			$class = ( $page['file'] === $current_page ) ? ' nav-tab-active' : '';
			$id    = '';

			if ( $action === 'update' && $page['file'] === 'settings' ) {
				$id           = ( isset( $_REQUEST["id"] ) ) ? absint( $_REQUEST["id"] ) : '';
				$page['name'] = __( 'Update', 'side-menu-lite' ) . ' #' . $id;
			} elseif ( $page['file'] === 'settings' && ( $action !== 'new' && $action !== 'duplicate' ) ) {
				continue;
			}

			echo '<a class="nav-tab' . esc_attr( $class ) . '" href="' . esc_url( Link::menu( $page['file'], $action, $id ) ) . '">' . esc_html( $page['name'] ) . '</a>';
		}
		echo '</h2>';
	}

	public static function get_current_page(): string {
		$default = DashboardHelper::first_file( 'pages' );

		return ( isset( $_REQUEST["tab"] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST["tab"] ) ) : $default;
	}

	public static function include_pages(): void {
		$current_page = self::get_current_page();

		$pages   = DashboardHelper::get_files( 'pages' );
		$default = DashboardHelper::first_file( 'pages' );

		$current = DashboardHelper::search_value( $pages, $current_page ) ? $current_page : $default;

		$file = DashboardHelper::get_file( $current, 'pages' );


		if ( $file !== false ) {
			$file = apply_filters( WOWP_Plugin::PREFIX . '_admin_filter_file', $file, $current );

			$page_path = DashboardHelper::get_folder_path( 'pages' ) . '/' . $file;

			if ( file_exists( $page_path ) ) {
				require_once $page_path;
			}
		}

	}

}