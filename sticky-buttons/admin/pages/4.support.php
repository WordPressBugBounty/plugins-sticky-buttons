<?php
/**
 * Page Name: Support
 *
 */

use StickyButtons\Admin\SupportForm;
use StickyButtons\WOWP_Plugin;

defined( 'ABSPATH' ) || exit;
?>

    <div class="wpie-block-tool is-white">

        <p>
			<?php
			esc_html_e( 'To get your support related question answered in the fastest timing, please send a message via the form below or write to us via', 'sticky-buttons' );
			echo ' <a href="' . esc_url( WOWP_Plugin::info( 'support' ) ) . '">' . esc_html__( 'support page', 'sticky-buttons' ) . '</a>';
			?>
        </p>

        <p>
			<?php esc_html_e( 'Also, you can send us your ideas and suggestions for improving the plugin.', 'sticky-buttons' ); ?>
        </p>

		<?php SupportForm::init(); ?>

    </div>
<?php
