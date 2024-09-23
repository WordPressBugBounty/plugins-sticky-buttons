<?php
/*
 * Page Name: Menu
 */

use StickyButtons\Admin\CreateFields;

defined( 'ABSPATH' ) || exit;

$page_opt = include( 'options/1.menu.php' );

$field = new CreateFields( $options, $page_opt );

$count = ( ! empty( $options['menu_1']['item_type'] ) ) ? count( $options['menu_1']['item_type'] ) : '0';
?>
    <div class="wpie-items__list" id="wpie-items-list">
		<?php if ( $count > 0 ) :
			for ( $i = 0; $i < $count; $i ++ ):
				$order = $i + 1;
				$item_order = ! empty( $options['item_sorter'][ $i ] ) ? 1 : 0;
				$open = ! empty( $item_order ) ? ' open' : '';
				?>
                <details class="wpie-item"<?php echo esc_attr( $open ); ?>>
                    <input type="hidden" name="param[item_sorter][]" class="wpie-item__toggle"
                           value="<?php echo absint( $item_order ); ?>">
                    <summary class="wpie-item_heading">
                        <span class="wpie-item_heading_icon"></span>
                        <span class="wpie-item_heading_label"></span>
                        <span class="wpie-item_heading_type"></span>
                        <span class="wpie-item_heading_sub"></span>
                        <span class="wpie-icon wpie_icon-chevron-expand-y"></span>
                        <span class="wpie-icon wpie_icon-trash"></span>
                        <span class="wpie-item_heading_toogle">
                            <span class="wpie-icon wpie_icon-chevron-down"></span>
                            <span class="wpie-icon wpie_icon-chevron-up "></span>
                        </span>
                    </summary>
                    <div class="wpie-item_content">

                        <div class="wpie-fieldset">
                            <div class="wpie-fields">
								<?php $field->create( 'menu_1-item_tooltip', $i ); ?>
                            </div>
                        </div>

                        <div class="wpie-tabs-wrapper">

                            <div class="wpie-tabs-link">
                                <a class="wpie-tab__link is-active"><?php esc_html_e( 'Type', 'sticky-buttons' ); ?></a>
                                <a class="wpie-tab__link"><?php esc_html_e( 'Icon', 'sticky-buttons' ); ?></a>
                                <a class="wpie-tab__link"><?php esc_html_e( 'Style', 'sticky-buttons' ); ?></a>
                                <a class="wpie-tab__link"><?php esc_html_e( 'Attributes', 'sticky-buttons' ); ?></a>
                            </div>

                            <div class="wpie-tab-settings is-active">
                                <div class="wpie-fieldset">
                                    <div class="wpie-fields">
										<?php $field->create( 'menu_1-item_type', $i ); ?>
										<?php $field->create( 'menu_1-item_link', $i ); ?>
                                    </div>
                                </div>


                            </div>

                            <div class="wpie-tab-settings">
                                <div class="wpie-fieldset">
                                    <div class="wpie-fields">
										<?php $field->create( 'menu_1-item_icon', $i ); ?>
                                    </div>
                                </div>

                            </div>

                            <div class="wpie-tab-settings">

                                <div class="wpie-fieldset">
                                    <div class="wpie-fields">
										<?php $field->create( 'menu_1-color', $i ); ?>
										<?php $field->create( 'menu_1-bcolor', $i ); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="wpie-tab-settings">
                                <div class="wpie-fieldset">
                                    <div class="wpie-legend"><?php esc_html_e( 'Attributes', 'sticky-buttons' ); ?></div>
                                    <div class="wpie-fields">
										<?php $field->create( 'menu_1-button_id', $i ); ?>
										<?php $field->create( 'menu_1-button_class', $i ); ?>
										<?php $field->create( 'menu_1-link_rel', $i ); ?>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </details>
			<?php endfor; endif; ?>

        <hr class="wpie-buttons__hr">
        <div class="wpie-fields">
            <button class="button button-primary wpie-add-button"
                    type="button"><?php esc_html_e( 'Add Button', 'sticky-buttons' ); ?></button>
        </div>

    </div>


    <template id="template-button">
        <details class="wpie-item" open>
            <input type="hidden" name="param[item_sorter][]" class="wpie-item__toggle" value="1">
            <summary class="wpie-item_heading">
                <span class="wpie-item_heading_icon"></span>
                <span class="wpie-item_heading_label"></span>
                <span class="wpie-item_heading_type"></span>
                <span class="wpie-item_heading_sub"></span>
                <span class="wpie-icon wpie_icon-chevron-expand-y"></span>
                <span class="wpie-icon wpie_icon-trash"></span>
                <span class="wpie-item_heading_toogle">
                    <span class="wpie-icon wpie_icon-chevron-down"></span>
                    <span class="wpie-icon wpie_icon-chevron-up "></span>
                </span>
            </summary>
            <div class="wpie-item_content">

                <div class="wpie-fieldset">
                    <div class="wpie-fields">
						<?php $field->create( 'menu_1-item_tooltip', - 1 ); ?>
                    </div>
                </div>

                <div class="wpie-tabs-wrapper">

                    <div class="wpie-tabs-link">
                        <a class="wpie-tab__link is-active"><?php esc_html_e( 'Type', 'sticky-buttons' ); ?></a>
                        <a class="wpie-tab__link"><?php esc_html_e( 'Icon', 'sticky-buttons' ); ?></a>
                        <a class="wpie-tab__link"><?php esc_html_e( 'Style', 'sticky-buttons' ); ?></a>
                        <a class="wpie-tab__link"><?php esc_html_e( 'Attributes', 'sticky-buttons' ); ?></a>
                    </div>

                    <div class="wpie-tab-settings is-active">
                        <div class="wpie-fieldset">
                            <div class="wpie-fields">
								<?php $field->create( 'menu_1-item_type', - 1 ); ?>
								<?php $field->create( 'menu_1-item_link', - 1 ); ?>
                            </div>
                        </div>


                    </div>

                    <div class="wpie-tab-settings">
                        <div class="wpie-fieldset">
                            <div class="wpie-fields">
								<?php $field->create( 'menu_1-item_icon', - 1 ); ?>
                            </div>
                        </div>

                    </div>

                    <div class="wpie-tab-settings">

                        <div class="wpie-fieldset">
                            <div class="wpie-fields">
								<?php $field->create( 'menu_1-color', - 1 ); ?>
								<?php $field->create( 'menu_1-bcolor', - 1 ); ?>
                            </div>
                        </div>
                    </div>

                    <div class="wpie-tab-settings">
                        <div class="wpie-fieldset">
                            <div class="wpie-legend"><?php esc_html_e( 'Attributes', 'sticky-buttons' ); ?></div>
                            <div class="wpie-fields">
								<?php $field->create( 'menu_1-button_id', - 1 ); ?>
								<?php $field->create( 'menu_1-button_class', - 1 ); ?>
								<?php $field->create( 'menu_1-link_rel', - 1 ); ?>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </details>
    </template>

<?php
