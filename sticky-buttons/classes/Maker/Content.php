<?php

namespace StickyButtons\Maker;

defined( 'ABSPATH' ) || exit;

class Content {
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

		$menu_add_classes = $position . $shape . $size . $space . $shadow . $animation;

		$action = '';

		if ( ! empty( $param['scroll'] ) && $param['scroll'] === 'show' ) {
			$action           = ' data-behavior="showScroll:' . absint( $param['scroll_position'] ) . '"';
			$menu_add_classes .= ' is-hidden';
		}
		if ( ! empty( $param['scroll'] ) && $param['scroll'] === 'hide' ) {
			$action = ' data-behavior="hideScroll:' . absint( $param['scroll_position'] ) . '"';
		}

		if ( ! empty( $param['timer_action'] ) && $param['timer_action'] === 'show' ) {
			$action           = ' data-behavior="showDelay:' . absint( $param['timer'] ) * 1000 . '"';
			$menu_add_classes .= ' is-hidden';
		}

		if ( ! empty( $param['timer_action'] ) && $param['timer_action'] === 'hide' ) {
			$action = ' data-behavior="hideDelay:' . absint( $param['timer'] ) * 1000 . '"';
		}

		$style = '';

		if ( ! empty( $param['zindex'] ) && $param['zindex'] !== '9' ) {
			$style .= '--z-index:' . absint( $param['zindex'] ) . ';';
		}

		if(! empty( $param['m_block'] )) {
			$style .= '--margin-block:' . esc_attr( $param['m_block'] ) . 'px;';
		}

		if(! empty( $param['m_inline'] )) {
			$style .= '--margin-inline:' . esc_attr( $param['m_inline'] ) . 'px;';
		}

		if(! empty( $param['gap'] )) {
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

		$css = '<style>'.trim( preg_replace( '~\s+~s', ' ', $css ) ).'</style>';

		return $css . '<ul class="sticky-buttons notranslate' . esc_attr( $menu_add_classes ) . '" id="sticky-buttons-' . absint( $id ) . '"' . $action . $style . '>';
	}

	private function elements( $count, $param ): string {
		$elements = '';

		for ( $i = 0; $i < $count; $i ++ ) {

			$item_type = $param['menu_1']['item_type'][ $i ];

			if ( $item_type === 'next_post' ) {
				$next_post = get_next_post( true );
				if ( empty( $next_post ) ) {
					continue;
				}
			} elseif ( $item_type === 'previous_post' ) {
				$previous_post = get_previous_post( true );
				if ( empty( $previous_post ) ) {
					continue;
				}
			}
			$style = '--color:' . esc_attr( $param['menu_1']['color'][ $i ] ) . ';';
			$style .= '--bg:' . esc_attr( $param['menu_1']['bcolor'][ $i ] ) . ';';

			$elements .= '<li style="' . esc_attr( $style ) . '">';
			$elements .= $this->create_element( $param, $i, $item_type );
			$elements .= '</li>';

		}

		return $elements;
	}

	private function create_element( $param, $i, $item_type ): string {
		$icon  = $this->create_icon( $param, $i );
		$label = $this->create_label( $param, $i, $item_type );

		$link = $this->create_link( $param, $i, $item_type, $icon, $label );

		return $link;
	}

	private function create_icon( $param, $i ): string {
		$icon = '';
		if ( ! empty( $param['menu_1']['item_custom'][ $i ] ) ) {
			$img_alt  = ! empty( $param['menu_1']['image_alt'][ $i ] ) ? $param['menu_1']['image_alt'][ $i ] : '';
			$img_link = $param['menu_1']['item_custom_link'][ $i ];
			$icon     = '<span class="sb-icon"><img src="' . esc_url( $img_link ) . '" alt="' . esc_attr( $img_alt ) . '"></span>';
		} elseif ( ! empty( $param['menu_1']['item_custom_text_check'][ $i ] ) ) {
			$icon = '<span class="sb-icon">' . wp_kses_post( $param['menu_1']['item_custom_text'][ $i ] ) . '</span>';
		} else {
			$icon_class   = $param['menu_1']['item_icon'][ $i ];
			$icon_animate = ! empty( $param['menu_1']['item_icon_anomate'][ $i ] ) ? ' ' . $param['menu_1']['item_icon_anomate'][ $i ] : '';
			$icon         = '<span class="sb-icon ' . esc_attr( $icon_class . $icon_animate ) . '"></span>';
		}

		return $icon;
	}

	private function create_label( $param, $i, $item_type ): string {
		$label = '';
		$text  = $param['menu_1']['item_tooltip'][ $i ];

		if ( $item_type === 'email' ) {
			$text = is_email( $text ) ? antispambot( $text ) : $text;
		}

		$open = ! empty( $param['menu_1']['hold_open'][ $i ] ) ? ' -visible' : '';

		$label = ! empty( $text ) ? '<span class="sb-label' . esc_attr( $open ) . '">' . esc_html( $text ) . '</span>' : '';

		return $label;
	}

	private function create_link( $param, $i, $item_type, $icon, $tooltip ): string {
		$link_param = $this->link_param( $param, $i );
		$menu       = '';

		switch ( $item_type ) {
			case 'link':
				$target = ! empty( $param['menu_1']['new_tab'][ $i ] ) ? '_blank' : '_self';
				$link   = ! empty( $param['menu_1']['item_link'][ $i ] ) ? $param['menu_1']['item_link'][ $i ] : '#';
				$menu   .= '<a href="' . esc_url( $link ) . '" target="' . esc_attr( $target ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu   .= $icon . $tooltip;
				$menu   .= '</a>';
				break;
			case 'download':
				$link     = ! empty( $param['menu_1']['item_link'][ $i ] ) ? $param['menu_1']['item_link'][ $i ] : '#';
				$download = ! empty( $param['menu_1']['download'][ $i ] ) ? ' download="' . esc_attr( $param['menu_1']['download'][ $i ] ) . '"' : ' download';
				$menu     .= '<a href="' . esc_attr( $link ) . '"' . $download . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu     .= $icon . $tooltip;
				$menu     .= '</a>';
				break;
			case 'share':
				$share_service = mb_strtolower( $param['menu_1']['item_share'][ $i ] );
				$menu          .= '<a href="#" data-action="share" data-target="' . esc_attr( $share_service ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu          .= $icon . $tooltip;
				$menu          .= '</a>';
				break;
			case 'translate':
				$glang = $param['menu_1']['gtranslate'][ $i ];
				$menu  .= '<a href="#" data-action="translate" data-target="' . esc_attr( $glang ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu  .= $icon . $tooltip;
				$menu  .= '</a>';
				break;
			case 'print':
			case 'totop':
			case 'tobottom':
			case 'goback':
			case 'goforward':
			case 'copyUrl':
			case 'bookmark':
				$menu .= '<a href="#" data-action="' . esc_attr( $item_type ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'smoothscroll':
				$link = ! empty( $param['menu_1']['item_link'][ $i ] ) ? $param['menu_1']['item_link'][ $i ] : '#';
				$menu .= '<a href="' . esc_attr( $link ) . '" data-action="' . esc_attr( $item_type ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'scrollSpy':
				$link = ! empty( $param['menu_1']['item_link'][ $i ] ) ? $param['menu_1']['item_link'][ $i ] : '#';
				$menu .= '<a href="' . esc_attr( $link ) . '" data-action="scrollSpy"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'login':
			case 'logout':
			case 'lostpassword':
				$link = call_user_func( 'wp_' . $item_type . '_url', $param['menu_1']['item_link'][ $i ] );
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'register':
				$link = wp_registration_url();
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'telephone':
				$link = 'tel:' . $param['menu_1']['item_link'][ $i ];
				$menu .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';
				break;
			case 'email':
				$email   = $param['menu_1']['item_link'][ $i ];
				$link    = is_email( $email ) ? 'mailto:' . antispambot( $email ) : $email;
				$tooltip = is_email( $tooltip ) ? antispambot( $tooltip ) : $tooltip;
				$menu    .= '<a href="' . esc_attr( $link ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu    .= $icon . $tooltip;
				$menu    .= '</a>';
				break;
			case 'next_post':
				$target    = ! empty( $param['menu_1']['new_tab'][ $i ] ) ? '_blank' : '_self';
				$next_post = get_next_post( true );
				$link      = get_permalink( $next_post );
				$menu      .= '<a href="' . esc_attr( $link ) . '" target="' . esc_attr( $target ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu      .= $icon . $tooltip;
				$menu      .= '</a>';
				break;
			case 'previous_post':
				$target        = ! empty( $param['menu_1']['new_tab'][ $i ] ) ? '_blank' : '_self';
				$previous_post = get_previous_post( true );
				$link          = get_permalink( $previous_post );
				$menu          .= '<a href="' . esc_attr( $link ) . '" target="' . esc_attr( $target ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu          .= $icon . $tooltip;
				$menu          .= '</a>';
				break;
			case 'font':
				$action = ! empty( $param['menu_1']['font'][ $i ] ) ? $param['menu_1']['font'][ $i ] : 'increase';
				$menu   .= '<a href="#" data-action="' . esc_attr( $item_type ) . '" data-target="' . esc_attr( $action ) . '"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu   .= $icon . $tooltip;
				$menu   .= '</a>';
				break;
			case 'popover':
				$link = 'popover-' . $this->id . '-' . $i;
				$menu .= '<a href="#' . esc_attr( $link ) . '" data-action="popover"' . wp_specialchars_decode( $link_param, 'double' ) . '>';
				$menu .= $icon . $tooltip;
				$menu .= '</a>';

				$style = '--popover-size:' . absint( $param['menu_1']['item_text_size'][ $i ] ) . 'px;';
				$style .= '--popover-inline:' . absint( $param['menu_1']['item_text_width'][ $i ] ) . 'px;';
				$style .= '--popover-block:' . absint( $param['menu_1']['item_text_height'][ $i ] ) . 'px;';
				$style .= '--popover-padding:' . absint( $param['menu_1']['item_text_padding'][ $i ] ) . 'px;';
				$style .= '--popover-border-color:' . esc_attr( $param['menu_1']['item_text_border_color'][ $i ] ) . ';';
				$style .= '--popover-backdrop:' . esc_attr( $param['menu_1']['item_text_background'][ $i ] ) . ';';
				$menu  .= '<div id="' . esc_attr( $link ) . '" popover style="' . esc_attr( $style ) . '">';
				$menu  .= wpautop( do_shortcode( wp_kses_post( $param['menu_1']['item_text'][ $i ] ) ) );
				$menu  .= '</div>';
				break;

		}

		return $menu;
	}

	private function generate_link(
		$url,
		$target = '',
		$icon = '',
		$tooltip = '',
		$link_param = '',
		$data_attr = '',
		$data_value = ''
	): string {
		$link = '<a href="' . esc_url( $url ) . '" ' . wp_specialchars_decode( $link_param, 'double' );
		$link .= ! empty( $target ) ? ' target="' . esc_attr( $target ) . '"' : '';
		$link .= ! empty( $data_attr ) ? ' ' . esc_attr( $data_attr ) . '="' . esc_attr( $data_value ) . '"' : '';
		$link .= '>';
		$link .= $icon . $tooltip;
		$link .= '</a>';

		return $link;
	}

	private function link_param( $param, $i ): string {

		$button_class = $param['menu_1']['button_class'][ $i ];
		$class_add    = ! empty( $button_class ) ? ' class="' . esc_attr( $button_class ) . '"' : '';
		$button_id    = $param['menu_1']['button_id'][ $i ];
		$id_add       = ! empty( $button_id ) ? ' id="' . esc_attr( $button_id ) . '"' : '';
		$link_rel     = ! empty( $param['menu_1']['link_rel'][ $i ] ) ? ' rel="' . esc_attr( $param['menu_1']['link_rel'][ $i ] ) . '"' : '';

		return $id_add . $class_add . $link_rel;
	}

}