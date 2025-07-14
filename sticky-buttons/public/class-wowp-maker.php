<?php


namespace StickyButtons;

use StickyButtons\Admin\DBManager;

defined( 'ABSPATH' ) || exit;

class WOWP_Maker {
	/**
	 * @var mixed
	 */
	private $id;
	/**
	 * @var mixed
	 */
	private $param;
	/**
	 * @var mixed
	 */
	private $title;

	public function __construct( $id, $param ) {
		$this->id    = $id;
		$this->param = $param;
	}

	public function init(): string {
		return $this->create();
	}

	private function create(): string {
		$id    = $this->id;
		$param = $this->param;

		$count = ! empty( $param['menu_1']['item_type'] ) ? count( $param['menu_1']['item_type'] ) : 0;

		if ( $count === 0 ) {
			return false;
		}

		$wrapper = $this->wrapper( $id, $param );

		$menu = $wrapper;

		$menu .= $this->elements( $count, $param );

		$menu .= '</ul>'; // close menu tags

		return $menu;
	}

	private function wrapper( $id, $param ): string {
		$position  = isset( $param['position'] ) ? ' ' . $param['position'] : ' -left-center';
		$shape     = isset( $param['shape'] ) ? ' ' . $param['shape'] : ' -square';
		$size      = isset( $param['size'] ) ? ' ' . $param['size'] : ' -medium';
		$space     = ! empty( $param['space'] ) ? ' -space' : '';
		$shadow    = ! empty( $param['shadow'] ) ? ' -shadow' : '';
		$animation = isset( $param['animation'] ) ? ' ' . $param['animation'] : '';
		$mobile    = isset( $param['mobile_on'] ) ? ' mobile-rule' : '';

		$type = '';

		if ( ! empty( $param['position_type'] ) ) {
			$type = ' is-' . esc_attr( $param['position_type'] );
		}


		$menu_add_classes = $position . $shape . $size . $space . $shadow . $animation . $mobile . $type;


		$style = '';

		if ( ! empty( $param['zindex'] ) && $param['zindex'] !== '9' ) {
			$style .= '--z-index:' . absint( $param['zindex'] ) . ';';
		}

		if ( ! empty( $param['m_block'] ) ) {
			$style .= '--margin-block:' . esc_attr( $param['m_block'] ) . 'px;';
		}

		if ( ! empty( $param['m_inline'] ) ) {
			$style .= '--margin-inline:' . esc_attr( $param['m_inline'] ) . 'px;';
		}

		if ( ! empty( $param['gap'] ) ) {
			$style .= '--gap:' . absint( $param['gap'] ) . 'px;';
		}

		$style = ! empty( $style ) ? ' style="' . esc_attr( $style ) . '"' : '';

		$css = '';
		if ( ! empty( $param['include_mobile'] ) ) {
			$screen = ! empty( $param['screen'] ) ? $param['screen'] : 480;
			$css    .= '
					@media only screen and (max-width: ' . absint( $screen ) . 'px){
						#sticky-buttons-' . absint( $id ) . ' {
							display:none;
						}
					}';
		}

		if ( ! empty( $param['include_more_screen'] ) ) {
			$screen_more = ! empty( $param['screen_more'] ) ? $param['screen_more'] : 1200;
			$css         .= '
					@media only screen and (min-width: ' . absint( $screen_more ) . 'px){
						#sticky-buttons-' . absint( $id ) . ' {
							display:none;
						}
					}';
		}

		if ( ! empty( $css ) ) {
			$css = '<style>' . trim( preg_replace( '~\s+~s', ' ', $css ) ) . '</style>';
		}

		$title = WOWP_Plugin::info( 'menu_title' );
		$data  = DBManager::get_data_by_id( $id );
		if ( $data !== false ) {
			$data_title = $data->title;
			if ( ! empty( $data_title ) ) {
				$title = $data_title;
			}
		}

		$out = $css;
		$out .= '<ul dir="ltr" class="sticky-buttons notranslate' . esc_attr( $menu_add_classes ) . '" id="sticky-buttons-' . absint( $id ) . '"' . $style . ' role="navigation" aria-label="' . esc_attr( $title ) . '"';

		if ( ! empty( $param['position_type'] ) && ! empty( $param['selector'] ) && ( $param['position_type'] === 'absolute' || $param['position_type'] === 'static' ) ) {
			$out .= ' data-selector="' . esc_attr( $param['selector'] ) . '"  data-inserted="' . esc_attr( $param['inserted'] ) . '"';
		}

		$out .= '>';

		return $out;
	}

	private function elements( $count, $param ): string {
		$elements = '';

		for ( $i = 0; $i < $count; $i ++ ) {

			$item_type = $param['menu_1']['item_type'][ $i ];

			$elements .= $this->create_element( $param, $i, $item_type );

		}

		return $elements;
	}

	private function create_element( $param, $i, $item_type ): string {
		$menu = $param['menu_1'];

		$style = '--color:' . esc_attr( $param['menu_1']['color'][ $i ] ) . ';';
		$style .= '--bg:' . esc_attr( $param['menu_1']['bcolor'][ $i ] ) . ';';


		if ( isset( $menu['label_font'] ) && $menu['label_font'] !== 'inherit' ) {
			$style .= '--_font-family:"' . esc_attr( $param['menu_1']['label_font'][ $i ] ) . '";';
		}

		if ( isset( $menu['label_style'] ) && $menu['label_style'] !== 'normal' ) {
			$style .= '--_font-style:' . esc_attr( $param['menu_1']['label_style'][ $i ] ) . ';';
		}

		if ( isset( $menu['label_weight'] ) && $menu['label_weight'] !== 'normal' ) {
			$style .= '--_font-weight:' . esc_attr( $param['menu_1']['label_weight'][ $i ] ) . ';';
		}

		$icon  = $this->create_icon( $param, $i );
		$label = $this->create_label( $param, $i, $item_type );
		$link  = $this->create_link( $param, $i, $item_type, $icon, $label );

		return "<li class='sb-item' style='" . esc_attr( $style ) . "'>{$link}</li>";
	}

	private function create_icon( $param, $i ): string {
		$icon = '';

		$icon_class   = $param['menu_1']['item_icon'][ $i ];
		$icon         = '<span class="sb-icon">';
		if ( ! empty( $icon_class ) ) {
			$icon .= '<span class="' . esc_attr( $icon_class ) . '" aria-hidden="true"></span>';
		}

		$icon .= '</span>';


		return $icon;
	}

	private function create_label( $param, $i, $item_type ): string {
		$label = '';
		$text  = esc_html( $param['menu_1']['item_tooltip'][ $i ] );

		if ( $item_type === 'email' ) {
			$text = is_email( $text ) ? antispambot( $text ) : $text;
		}

		$label = ! empty( $text ) ? '<span class="sb-label">' . $text . '</span>' : '';

		return $label;
	}
	
	private function create_link( $param, $i, $item_type, $icon, $tooltip ): string {
		$link_param = $this->link_param( $param, $i );
		$menu       = '';

		switch ( $item_type ) {
			case 'link':
				$target = ! empty( $param['menu_1']['new_tab'][ $i ] ) ? '_blank' : '_self';
				$link   = ! empty( $param['menu_1']['item_link'][ $i ] ) ? $param['menu_1']['item_link'][ $i ] : '#';
				$menu   .= '<a href="' . esc_url( $link ) . '" data-action="link" target="' . esc_attr( $target ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu   .= $icon . $tooltip;
				$menu   .= '</a>';
				break;
			case 'login':
			case 'logout':
			case 'lostpassword':
				$link = call_user_func( 'wp_' . $item_type . '_url', $param['menu_1']['item_link'][ $i ] );
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . ' data-action="link">';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'register':
				$link = wp_registration_url();
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' )  . ' data-action="link">';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'telephone':
				$link = 'tel:' . $param['menu_1']['item_link'][ $i ];
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' )  . ' data-action="link">';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'email':
				$email   = $param['menu_1']['item_link'][ $i ];
				$link    = is_email( $email ) ? 'mailto:' . antispambot( $email ) : $email;
				$tooltip = is_email( $tooltip ) ? antispambot( $tooltip ) : $tooltip;
				$menu    .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . ' data-action="link">';
				$menu    .= $icon . $tooltip;
				$menu    .= '</a>';
				break;
			case 'function':
				$link = $param['menu_1']['item_link'][ $i ];
				$menu .= '<button data-action="function"  data-target="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</button>';
				break;
			default:
				$target = ! empty( $param['menu_1']['new_tab'][ $i ] ) ? '_blank' : '_self';
				$link   = ! empty( $param['menu_1']['item_link'][ $i ] ) ? $param['menu_1']['item_link'][ $i ] : '#';
				$menu   .= '<a href="' . esc_url( $link ) . '" data-action="link" target="' . esc_attr( $target ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu   .= $icon . $tooltip;
				$menu   .= '</a>';
				break;
		}

		return $menu;
	}

	private function link_param( $param, $i ): string {
		$class_add = ' class="sb-link';
		if ( ! empty( $param['menu_1']['button_class'][ $i ] ) ) {
			$class_add .= ' ' . esc_attr( $param['menu_1']['button_class'][ $i ] );
		}
		$class_add .= '"';

		$button_id  = $param['menu_1']['button_id'][ $i ];
		$id_add     = ! empty( $button_id ) ? ' id="' . esc_attr( $button_id ) . '"' : '';
		$link_rel   = ! empty( $param['menu_1']['link_rel'][ $i ] ) ? ' rel="' . esc_attr( $param['menu_1']['link_rel'][ $i ] ) . '"' : '';
		$aria_label = ! empty( $param['menu_1']['aria_label'][ $i ] ) ? ' aria-label="' . esc_attr( $param['menu_1']['aria_label'][ $i ] ) . '"' : '';

		return $id_add . $class_add . $link_rel . $aria_label;
	}

}