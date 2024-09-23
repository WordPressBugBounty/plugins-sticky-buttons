<?php
/**
 * Class WOWP_Public
 *
 * This class handles the public functionality of the Float Menu Pro plugin.
 *
 * @package    StickyButtons
 * @subpackage Public
 * @author     Dmytro Lobov <hey@wow-company.com>, Wow-Company
 * @copyright  2024 Dmytro Lobov
 * @license    GPL-2.0+
 */

namespace StickyButtons;

use StickyButtons\Admin\DBManager;
use StickyButtons\Maker\Content;
use StickyButtons\Publish\Conditions;
use StickyButtons\Publish\Display;
use StickyButtons\Publish\Singleton;

defined( 'ABSPATH' ) || exit;

class WOWP_Public {

	private string $pefix;

	public function __construct() {
		// prefix for plugin assets
		$this->pefix = '.min';

		add_shortcode( WOWP_Plugin::SHORTCODE, [ $this, 'shortcode' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'assets' ] );
		add_action( 'wp_footer', [ $this, 'footer' ] );

	}


	public function shortcode( $atts ) {
		$atts = shortcode_atts(
			[ 'id' => "" ],
			$atts,
			WOWP_Plugin::SHORTCODE
		);

		if ( empty( $atts['id'] ) ) {
			return '';
		}

		$singleton = Singleton::getInstance();

		if ( $singleton->hasKey( $atts['id'] ) ) {
			return '';
		}

		$result = DBManager::get_data_by_id( $atts['id'] );

		if ( empty( $result->param ) ) {
			return '';
		}

		$conditions = Conditions::init( $result );

		if ( $conditions === false ) {
			return '';
		}

		$param = maybe_unserialize( $result->param );
		$singleton->setValue( $atts['id'], $param );

		return '';
	}

	public function assets(): void {
		$handle          = WOWP_Plugin::SLUG;
		$assets          = plugin_dir_url( __FILE__ ) . 'assets/';
		$version         = WOWP_Plugin::info( 'version' );
		$url_fontawesome = WOWP_Plugin::url() . 'vendors/fontawesome/css/all.css';


		$this->check_display();
		$this->check_shortcode();

		$singleton = Singleton::getInstance();
		$args      = $singleton->getValue();

		if ( ! empty( $args ) ) {
			wp_enqueue_style( $handle, $assets . 'css/style'. $this->pefix . '.css', [], $version,  'all' );
		}
		foreach ( $args as $id => $param ) {
			if ( empty( $param['fontawesome'] ) ) {
				wp_enqueue_style( $handle . '-fontawesome', $url_fontawesome, null, '6.6' );
			}
		}
	}


	public function footer(): void {
		$handle          = WOWP_Plugin::SLUG;
		$assets          = plugin_dir_url( __FILE__ ) . 'assets/';
		$version         = WOWP_Plugin::info( 'version' );
		$url_fontawesome = WOWP_Plugin::url() . 'vendors/fontawesome/css/all.css';

		$singleton = Singleton::getInstance();
		$args      = $singleton->getValue();

		if ( empty( $args ) ) {
			return;
		}

		wp_enqueue_style( $handle, $assets . 'css/style'. $this->pefix . '.css', [], $version,  'all' );

		foreach ( $args as $id => $param ) {
			$content = new Content( $id, $param );
			echo $content->init();
			if ( empty( $param['fontawesome'] ) ) {
				wp_enqueue_style( $handle . '-fontawesome', $url_fontawesome, null, '6.6' );
			}

		}
	}

	private function check_display(): void {
		$results = DBManager::get_all_data();
		if ( $results !== false ) {
			$singleton = Singleton::getInstance();
			foreach ( $results as $result ) {
				$param = maybe_unserialize( $result->param );
				if ( Display::init( $result->id, $param ) === true && Conditions::init( $result ) === true ) {
					$singleton->setValue( $result->id, $param );
				}
			}
		}
	}

	private function check_shortcode(): void {
		global $post;
		$shortcode = WOWP_Plugin::SHORTCODE;
		$singleton = Singleton::getInstance();

		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, $shortcode ) ) {
			$pattern = get_shortcode_regex( [ $shortcode ] );
			if ( preg_match_all( '/' . $pattern . '/s', $post->post_content, $matches )
			     && array_key_exists( 2, $matches )
			     && in_array( $shortcode, $matches[2] )
			) {
				foreach ( $matches[3] as $attrs ) {
					$attrs = shortcode_parse_atts( $attrs );
					if ( $attrs && is_array( $attrs ) && array_key_exists( 'id', $attrs ) ) {
						$result = DBManager::get_data_by_id( $attrs['id'] );

						if ( ! empty( $result->param ) ) {
							$param = maybe_unserialize( $result->param );
							if ( Conditions::init( $result ) === true ) {
								$singleton->setValue( $attrs['id'], $param );
							}
						}

					}
				}
			}
		}
	}


}