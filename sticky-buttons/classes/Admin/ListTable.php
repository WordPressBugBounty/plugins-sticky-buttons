<?php

/**
 * Class ListTable
 *
 * @package    WowPlugin
 * @subpackage Admin
 * @author     Dmytro Lobov <dev@wow-company.com>, Wow-Company
 * @copyright  2024 Dmytro Lobov
 * @license    GPL-2.0+
 *
 * @see https://developer.wordpress.org/reference/classes/wp_list_table/
 */

namespace StickyButtons\Admin;

defined( 'ABSPATH' ) || exit;

use WP_List_Table;
use StickyButtons\WOWP_Plugin;

class ListTable extends WP_List_Table {

	public int $per_page = 30;

	public function __construct() {
		// Set parent defaults
		parent::__construct( array(
			'ajax' => false,
		) );
		$this->process_bulk_action();
	}

	public function column_default( $item, $column_name ) {
		return $item[ $column_name ];
	}

	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	public function search_box( $text, $input_id ): void {
		$input_id .= '-search-input';
		if ( ! empty( $_REQUEST['orderby'] ) ) {
			$orderby = sanitize_text_field( wp_unslash( $_REQUEST['orderby'] ) );
			echo '<input type="hidden" name="orderby" value="' . esc_attr( $orderby ) . '" />';
		}

		if ( ! empty( $_REQUEST['order'] ) ) {
			$order = sanitize_text_field( wp_unslash( $_REQUEST['order'] ) );
			echo '<input type="hidden" name="order" value="' . esc_attr( $order ) . '" />';
		}
		?>
        <p class="search-box">
            <label class="screen-reader-text" for="<?php echo esc_attr( $input_id ) ?>">
				<?php echo esc_attr( $text ); ?>:
            </label>
            <input type="search" id="<?php echo esc_attr( $input_id ) ?>" name="s"
                   value="<?php _admin_search_query(); ?>"/>
			<?php submit_button( $text, 'button', false, false, array( 'ID' => 'search-submit' ) ); ?>
        </p>
		<?php
	}

	// phpcs:enable

	public function column_title( $item ): string {
		$title   = ! empty( $item['title'] ) ? $item['title'] : __( 'Untitled', 'sticky-buttons' );
		$param   = DBManager::get_param_id( $item['ID'] );
		$actions = [
			'id'        => '#' . $item['ID'],
			'edit'      => '<a href="' . esc_url( Link::edit( $item['ID'] ) ) . '">' . esc_attr__( 'Edit',
					'sticky-buttons' ) . '</a>',
			'duplicate' => '<a href="' . esc_url( Link::duplicate( $item['ID'] ) ) . '">' . esc_attr__( 'Duplicate',
					'sticky-buttons' ) . '</a>',
			'delete'    => '<a href="' . esc_url( Link::remove( $item['ID'] ) ) . '" >' . esc_attr__( 'Delete',
					'sticky-buttons' ) . '</a>',
			'export'    => '<a href="' . esc_url( Link::export( $item['ID'] ) ) . '" >' . esc_attr__( 'Export',
					'sticky-buttons' ) . '</a>',
		];
		if ( ! empty( $param['link'] ) ) {
			$actions['view'] = '<a href="' . esc_url( $param['link'] ) . '" target="_blank">' . esc_attr__( 'View',
					'sticky-buttons' ) . '</a>';
		}


		return $title . $this->row_actions( $actions );
	}

	public function prepare_items(): void {
		$columns     = $this->get_columns();
		$hidden      = $this->get_hidden_columns();
		$sortable    = $this->get_sortable_columns();
		$data        = $this->table_data();
		$perPage     = 30;
		$currentPage = $this->get_pagenum();
		if ( $data ) {
			usort( $data, [ &$this, 'sort_data' ] );
			$data = array_slice( $data, ( ( $currentPage - 1 ) * $perPage ), $perPage );
		}
		$totalItems            = $this->list_count();
		$this->_column_headers = [ $columns, $hidden, $sortable ];
		$this->items           = $data;
		$this->set_pagination_args( [
			'total_items' => $totalItems,
			'per_page'    => $perPage,
			'total_pages' => ceil( $totalItems / $perPage ),
		] );
	}

	public function get_columns(): array {
		return [
			'cb'     => '<input type="checkbox" />',
			'title'  => __( 'Title', 'sticky-buttons' ),
			'code'   => __( 'Shortcode', 'sticky-buttons' ),
			'tag'    => __( 'Tag', 'sticky-buttons' ),
			'mode'   => __( 'Test mode',
					'sticky-buttons' ) . '<sup class="has-tooltip" data-tooltip="' . __( 'The item will only be displayed for administrators.',
					'sticky-buttons' ) . '">ℹ</sup>',
			'status' => __( 'Status',
					'sticky-buttons' ) . '<sup class="has-tooltip" data-tooltip="' . __( 'The item will only be displayed for administrators.',
					'sticky-buttons' ) . '">ℹ</sup>',
		];
	}

	public function get_hidden_columns(): array {
		return [];
	}

	public function get_sortable_columns(): array {
		return [
			'ID' => [ 'ID', false ],
		];
	}

	private function table_data(): array {
		$data   = [];
		$paged  = $this->get_paged();
		$offset = $this->per_page * ( $paged - 1 );

		$result = $this->get_results();

		$slug      = WOWP_Plugin::SLUG;
		$shortcode = WOWP_Plugin::SHORTCODE;

		if ( empty( $result ) ) {
			return $data;
		}

		$main_link = add_query_arg( [
			'page'   => $slug,
			'tab'    => 'settings',
			'action' => 'update'
		], admin_url( 'admin.php' ) );
		foreach ( $result as $key => $value ) {
			$title       = ! empty( $value->title ) ? $value->title : __( 'UnTitle', 'sticky-buttons' );
			$tooltip_off = esc_attr__( 'Click for Deactivate.', 'sticky-buttons' );
			$tooltip_on  = esc_attr__( 'Click for Activate.', 'sticky-buttons' );
			$status_off  = '<a href="' . esc_url( Link::activate_url( $value->id ) ) . '" class="wpie-toogle is-off" data-tooltip="' . esc_attr( $tooltip_on ) . '"><span>' . esc_attr__( 'OFF',
					'sticky-buttons' ) . '</span></a>';
			$status_on   = '<a href="' . esc_url( Link::deactivate_url( $value->id ) ) . '" class="wpie-toogle is-on" data-tooltip="' . esc_attr( $tooltip_off ) . '"><span>' . esc_attr__( 'ON',
					'sticky-buttons' ) . '</span></a>';
			$status      = ! empty( $value->status ) ? $status_off : $status_on;

			$mode_tooltip_off = esc_attr__( 'Click for OFF.', 'sticky-buttons' );
			$mode_tooltip_on  = esc_attr__( 'Click for ON.', 'sticky-buttons' );

			$mode_off = '<a href="' . esc_url( Link::activate_mode( $value->id ) ) . '" class="wpie-toogle is-off" data-tooltip="' . esc_attr( $mode_tooltip_on ) . '"><span>' . esc_attr__( 'OFF',
					'sticky-buttons' ) . '</span></a>';
			$mode_on  = '<a href="' . esc_url( Link::deactivate_mode( $value->id ) ) . '" class="wpie-toogle is-on" data-tooltip="' . esc_attr( $mode_tooltip_off ) . '"><span>' . esc_attr__( 'ON',
					'sticky-buttons' ) . '</span></a>';

			$mode = empty( $value->mode ) ? $mode_off : $mode_on;

			$tag = '';
			if ( isset( $value->tag ) ) {
				$tag_url = add_query_arg( [
					'page' => WOWP_Plugin::SLUG,
					'tag'  => $value->tag
				], admin_url( 'admin.php' ) );
				$tag     = '<a href="' . esc_url( $tag_url ) . '">' . esc_attr( $value->tag ) . '</a>';
			}

			$link   = add_query_arg( [ 'id' => $value->id ], $main_link );
			$data[] = array(
				'ID'     => $value->id,
				'title'  => '<a href="' . esc_url( $link ) . '">' . esc_attr( $title ) . '</a>',
				'code'   => '<div class="wpie-field">
                    <label class="wpie-field__label has-icon">
                        <span class="has-tooltip is-pointer on-right can-copy" data-tooltip="Copy"><span class="dashicons dashicons-shortcode is-pointer" ></span></span>
                        <input type="text" value="[' . esc_attr( $shortcode ) . ' id=\'' . absint( $value->id ) . '\']" readonly>
                    </label>
                </div>',
				'tag'    => $tag,
				'mode'   => $mode,
				'status' => $status,
			);
		}

		return $data;
	}

	public function column_cb( $item ) {
		return sprintf( '<input type="checkbox" name="%1$s[]" value="%2$s" />', 'ID', $item['ID'] );
	}

	public function get_paged(): int {
		return isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	}

	public function get_search() {
		$verify = AdminActions::verify( WOWP_Plugin::PREFIX . '_list_action' );

		if ( ! $verify ) {
			return false;
		}

		// phpcs:disable WordPress.Security.NonceVerification.Missing -- Nonce verification is handled elsewhere.
		return ! empty( $_POST['s'] ) ? urldecode( trim( sanitize_text_field( wp_unslash( $_POST['s'] ) ) ) ) : false;
		// phpcs:enable
	}

	public function list_count(): int {
		$result = $this->get_results();

		if ( empty( $result ) ) {
			return 0;
		}
		$count = count( $result );

		return (int) $count;
	}

	public function get_results() {
		global $wpdb;

		$search = $this->get_search();

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$tag_search = ( ! empty( $_REQUEST['tag'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST  ['tag'] ) ) : '';
		$tag_search = ( $tag_search === 'all' ) ? '' : $tag_search;


		$result = '';

		$table = esc_sql($wpdb->prefix . WOWP_Plugin::PREFIX);

        // Table name is sanitized elsewhere.
		if ( empty( $search ) ) {
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$result = $wpdb->get_results( "SELECT * FROM {$table} ORDER BY id DESC" );
			if ( ! empty( $tag_search ) ) {
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table} WHERE tag=%s ORDER BY id DESC",
					$tag_search ) );
			}
		} elseif ( trim( $search ) === 'UnTitle' ) {
			// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$result = $wpdb->get_results( "SELECT * FROM {$table} WHERE title='' ORDER BY id DESC" );
			if ( ! empty( $tag_search ) ) {
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table} WHERE title='' AND tag=%s ORDER BY id DESC",
					$tag_search ) );
			}
		} elseif ( is_numeric( $search ) ) {
			if ( ! empty( $tag_search ) ) {
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table} WHERE id=%d AND tag=%s ORDER BY id DESC",
					absint( $search ), $tag_search ) );
			} else {
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table} WHERE id=%d ORDER BY id DESC",
					absint( $search ) ) );
			}
		} else {
			$wild = '%';
			$find = sanitize_text_field( $search );
			$like = $wild . $wpdb->esc_like( $find ) . $wild;
			if ( ! empty( $tag_search ) ) {
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table} WHERE title LIKE %s AND tag=%s ORDER BY id DESC",
					$like, $tag_search ) );
			} else {
				// phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
				$result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table} WHERE title LIKE %s ORDER BY id DESC",
					$like ) );
			}
		}

		return $result;
	}


	public function get_bulk_actions(): array {
		$actions = [
			'delete'     => __( 'Delate', 'sticky-buttons' ),
			'activate'   => __( 'Activate', 'sticky-buttons' ),
			'deactivate' => __( 'Deactivate', 'sticky-buttons' ),
			'test_on'    => __( 'Test mode ON', 'sticky-buttons' ),
			'test_off'   => __( 'Test mode OFF', 'sticky-buttons' ),
		];

		return $actions;
	}

	public function process_bulk_action() {
		$verify = AdminActions::verify( WOWP_Plugin::PREFIX . '_list_action' );

		if ( ! $verify ) {
			return false;
		}
		// phpcs:ignore WordPress.Security.NonceVerification.Missing
		$ids    = isset( $_POST['ID'] ) ? ( map_deep( $_POST['ID'], 'absint' ) ) : false;
		$action = $this->current_action();
		if ( ! is_array( $ids ) ) {
			$ids = [ $ids ];
		}
		if ( empty( $action ) ) {
			return false;
		}

		foreach ( $ids as $id ) {
			if ( 'delete' === $this->current_action() ) {
				DBManager::delete( $id );
			}
			if ( 'activate' === $this->current_action() ) {
				Settings::activate_item( $id );
			}
			if ( 'deactivate' === $this->current_action() ) {
				Settings::deactivate_item( $id );
			}
			if ( 'test_on' === $this->current_action() ) {
				Settings::activate_mode( $id );
			}
			if ( 'test_off' === $this->current_action() ) {
				Settings::deactivate_mode( $id );
			}
		}
	}

	protected function extra_tablenav( $which ): void {
		if ( 'top' === $which ) {
			$tags = DBManager::get_tags_from_table();

			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$tag_search = ( ! empty( $_REQUEST['tag'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['tag'] ) ) : '';
			$tag_search = ( $tag_search === 'all' ) ? '' : $tag_search;

			echo '<div class="alignleft actions"><label for="filter-by-tag" class="screen-reader-text">' . esc_html__( 'Filter by tag',
					'sticky-buttons' ) . '</label>';
			echo '<select name="tag" id="filter-by-tag">';
			echo '<option value="all"' . selected( 'all', $tag_search, false ) . '>' . esc_html__( 'All',
					'sticky-buttons' ) . '</option>';

			if ( ! empty( $tags ) ) {
				foreach ( $tags as $tag ) {
					if ( empty( $tag['tag'] ) ) {
						continue;
					}
					echo '<option value="' . esc_attr( trim( $tag['tag'] ) ) . '"' . selected( $tag['tag'], $tag_search,
							false ) . '>' . esc_html( $tag['tag'] ) . '</option>';
				}
			}
			echo '</select>';
			submit_button( __( 'Filter', 'sticky-buttons' ), 'secondary', 'action', false );
			echo '</div>';
		}
	}

	private function sort_data( $a, $b ): int {
		// If no sort, default to title
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$orderby = ( ! empty( $_GET['orderby'] ) ) ? sanitize_text_field( wp_unslash($_GET['orderby']) ) : 'ID';
		// If no order, default to asc
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$order = ( ! empty( $_GET['order'] ) ) ? sanitize_text_field( wp_unslash($_GET['order']) ) : 'desc';
		// Determine sort order
		$result = strnatcmp( $a[ $orderby ], $b[ $orderby ] );

		// Send final sort direction to usort
		return ( $order === 'asc' ) ? $result : - $result;
	}

}