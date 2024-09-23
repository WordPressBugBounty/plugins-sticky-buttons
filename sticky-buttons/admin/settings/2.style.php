<?php

/*
 * Page Name: Style
 */

use StickyButtons\Admin\CreateFields;

defined( 'ABSPATH' ) || exit;

$page_opt = include( 'options/2.style.php' );

$field = new CreateFields( $options, $page_opt );


$item_order = ! empty( $options['item_order']['properties'] ) ? 1 : 0;
$open       = ! empty( $item_order ) ? ' open' : '';
?>

<details class="wpie-item"<?php echo esc_attr( $open ); ?>>
	<input type="hidden" name="param[item_order][properties]" class="wpie-item__toggle"
	       value="<?php echo absint( $item_order ); ?>">
	<summary class="wpie-item_heading">
		<span class="wpie-item_heading_icon"><span class="wpie-icon wpie_icon-ruler-pen"></span></span>
		<span class="wpie-item_heading_label"><?php esc_html_e( 'Properties', 'sticky-buttons' ); ?></span>
		<span class="wpie-item_heading_type"></span>
		<span class="wpie-item_heading_toogle">
        <span class="wpie-icon wpie_icon-chevron-down"></span>
        <span class="wpie-icon wpie_icon-chevron-up "></span>
    </span>
	</summary>
	<div class="wpie-item_content">

		<div class="wpie-fieldset">
			<div class="wpie-fields">
			<?php $field->create( 'zindex' ); ?>
			<?php $field->create( 'animation' ); ?>
			</div>
		</div>

	</div>
</details>

<?php
$item_order = ! empty( $options['item_order']['location'] ) ? 1 : 0;
$open       = ! empty( $item_order ) ? ' open' : '';
?>

<details class="wpie-item"<?php echo esc_attr( $open ); ?>>
	<input type="hidden" name="param[item_order][location]" class="wpie-item__toggle"
	       value="<?php echo absint( $item_order ); ?>">
	<summary class="wpie-item_heading">
		<span class="wpie-item_heading_icon"><span class="wpie-icon wpie_icon-pointer"></span></span>
		<span class="wpie-item_heading_label"><?php esc_html_e( 'Location', 'sticky-buttons' ); ?></span>
		<span class="wpie-item_heading_type"></span>
		<span class="wpie-item_heading_toogle">
        <span class="wpie-icon wpie_icon-chevron-down"></span>
        <span class="wpie-icon wpie_icon-chevron-up "></span>
    </span>
	</summary>
	<div class="wpie-item_content">

		<div class="wpie-fieldset">
			<div class="wpie-fields">
			    <?php $field->create( 'position' ); ?>
			    <?php $field->create( 'm_block' ); ?>
			    <?php $field->create( 'm_inline' ); ?>
			</div>
		</div>

	</div>
</details>

<?php
$item_order = ! empty( $options['item_order']['appearance'] ) ? 1 : 0;
$open       = ! empty( $item_order ) ? ' open' : '';
?>

<details class="wpie-item"<?php echo esc_attr( $open ); ?>>
	<input type="hidden" name="param[item_order][appearance]" class="wpie-item__toggle"
	       value="<?php echo absint( $item_order ); ?>">
	<summary class="wpie-item_heading">
		<span class="wpie-item_heading_icon"><span class="wpie-icon wpie_icon-paintbrush"></span></span>
		<span class="wpie-item_heading_label"><?php esc_html_e( 'Appearance', 'sticky-buttons' ); ?></span>
		<span class="wpie-item_heading_type"></span>
		<span class="wpie-item_heading_toogle">
        <span class="wpie-icon wpie_icon-chevron-down"></span>
        <span class="wpie-icon wpie_icon-chevron-up "></span>
    </span>
	</summary>
	<div class="wpie-item_content">

		<div class="wpie-fieldset">
			<div class="wpie-fields">
				<?php $field->create( 'shape' ); ?>
				<?php $field->create( 'size' ); ?>
				<?php $field->create( 'shadow' ); ?>
				<?php $field->create( 'gap' ); ?>
			</div>

		</div>

	</div>
</details>

<?php
