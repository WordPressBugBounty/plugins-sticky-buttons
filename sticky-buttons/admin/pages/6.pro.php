<?php
/**
 * Page Name: Upgrade to Pro
 *
 */

use StickyButtons\WOWP_Plugin;

$features = [
	'core'             => [
		[
			'title' => __( 'Submenus', 'sticky-buttons' ),
			'desc'  => __( 'By grouping related items under submenu, you can improve user experience by making navigation more intuitive and organized. Users can easily find the specific information they need without feeling overwhelmed by a long list of top-level menu items.', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/sub-menus/',
		],
		[
			'title' => __( 'Beautiful Label Animations', 'sticky-buttons' ),
			'desc'  => __( 'Choose from 8 elegant animations to showcase your menu item label.', 'sticky-buttons' ),
			'link'  => 'https://share.cleanshot.com/QL3hWlJ0',
		],
		[
			'title' => __( 'Deeper Analytics', 'sticky-buttons' ),
			'desc'  => __( 'Empower with a deeper understanding of how users interact with your menu! This powerful feature allows you to track user clicks on specific menu items within Google Analytics.', 'sticky-buttons' ),
		],
		[
			'title' => __( 'Icon with Text', 'sticky-buttons' ),
			'desc'  => __( 'Combine an icon with a short text label inside a single button. This clear and intuitive visual cue improves menu clarity and enhances user experience.', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/icon-with-text/',
		],
		[
			'title' => __( 'Create Popup', 'sticky-buttons' ),
			'desc'  => __( 'Configure popups that open upon clicking on menu items. Click "Open Popup" on demo page', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/actions/',
		],

	],
	'functional-links' => [
		[
			'title' => __( 'Social Sharing', 'sticky-buttons' ),
			'desc'  => __( 'Boost your website\'s reach by incorporating a "Share" link. Choose from a staggering 29 different social media services, allowing users to effortlessly share your content across their preferred platforms.', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/share/',
		],
		[
			'title' => __( 'Translate', 'sticky-buttons' ),
			'desc'  => __( 'Empower your visitors to translate your website content in real-time. Integrate this link type to break down language barriers and cater to a global audience.', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/translate/',
		],
		[
			'title' => __( 'Reaction Button', 'sticky-buttons' ),
			'desc'  => __( 'The Reaction button type allows users to quickly respond to your content using emoji-based feedback such as Like, Helpful, or Confused.', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/reactions/',
		],
        [
			'title' => __( 'Text Share & Copy', 'sticky-buttons' ),
			'desc'  => __( 'The Text Share & Copy feature enables users to share or copy specific pieces of text defined by a CSS selector.', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/text-share-copy/',
		],
        [
			'title' => __( 'Favorites', 'sticky-buttons' ),
			'desc'  => __( 'The Favorites feature lets users mark pages or items as favorites by clicking a star button.', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/favorites/',
		],
		[
			'title' => __( 'Media Control', 'sticky-buttons' ),
			'desc'  => __( 'The Media Control feature adds floating buttons that let users interact with audio or video elements on the page using actions like play, pause, mute, loop, reset, volume up, and volume down.', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/media-control/',
		],
		[
			'title' => __( 'Next/Previous Post', 'sticky-buttons' ),
			'desc'  => __( 'Simplify post navigation for readers. These link types automatically direct users to the next or previous post within the current category, keeping them engaged and exploring related content. ', 'sticky-buttons' ),
			'link'  => 'https://share.cleanshot.com/WbSMXGD4',
		],
		[
			'title' => __( 'ScrollSpy', 'sticky-buttons' ),
			'desc'  => __( 'The ScrollSpy feature tracks the user\'s scroll position and automatically highlights the active menu item linked to the currently visible section.', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/scrollspy/',
		],
		[
			'title' => __( 'Forced Download', 'sticky-buttons' ),
			'desc'  => __( 'Offer downloadable resources like brochures, ebooks, or software directly through your floating menus. This eliminates the need for users to navigate to separate download pages. ', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/actions/',
		],
		[
			'title' => __( 'Scroll To Top/Bottom', 'sticky-buttons' ),
			'desc'  => __( 'Provide users with convenient links to instantly scroll to the top or bottom of your webpage. This is particularly helpful for long pages or content-heavy sections.', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/scrolling/',
		],
		[
			'title' => __( 'Smooth Scroll', 'sticky-buttons' ),
			'desc'  => __( 'Enhance user experience with smooth scrolling animations. This link type ensures a visually pleasing and seamless transition when users navigate to different sections of your webpage.', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/scrolling/',
		],
		[
			'title' => __( 'Print', 'sticky-buttons' ),
			'desc'  => __( 'With a single click on the Print link, users can initiate the built-in printing function of their web browser. No more cumbersome text selection or manual copying.', 'sticky-buttons' ),
			'demo'  => 'https://demo.wow-estore.com/sticky-buttons-pro/actions/',
		],

	],

	'icons'              => [
		[
			'title' => __( 'Custom Icons', 'sticky-buttons' ),
			'desc'  => __( 'Break free from the limitations of pre-defined icon libraries. Custom icons allow you to utilize any image or icon that complements your website\'s design.', 'sticky-buttons' ),
			'link'  => 'https://share.cleanshot.com/ZDFLlf32',
		],
        [
			'title' => __( 'Icon Animations', 'sticky-buttons' ),
			'desc'  => __( 'The Icon Animations feature allows you to apply attention-grabbing animations to button icons, such as bounce, pulse, spin, or shake.', 'sticky-buttons' ),
			'link'  => 'https://demo.wow-estore.com/sticky-buttons-pro/icon-animations/',
		],
	],
	'visibility-control' => [
		[
			'title' => __( 'Scroll-Based Visibility', 'sticky-buttons' ),
			'desc'  => __( 'Display or hide buttons dynamically, based on users\' scroll positions, ensuring relevance and minimizing distractions.', 'sticky-buttons' ),
			'link'  => 'https://demo.wow-estore.com/sticky-buttons-pro/hide-after-position/',
		],
        [
			'title' => __( 'Timer Action', 'sticky-buttons' ),
			'desc'  => __( 'Hide or display buttons after a set number of seconds, allowing precise timing for button visibility. ', 'sticky-buttons' ),
			'link'  => 'https://demo.wow-estore.com/sticky-buttons-pro/timer-for-hide-menu/',
		],
		[
			'title' => __( 'Activate by URL', 'sticky-buttons' ),
			'desc'  => __( 'Target specific pages based on URL parameters (e.g., show a sticky buttons only on a page with URL parameter)', 'sticky-buttons' ),
			'link'  => 'https://share.cleanshot.com/YMfrzptP',
		],
        [
			'title' => __( 'Activate by Referrer URL', 'sticky-buttons' ),
			'desc'  => __( ' To display different floating menus for visitors arriving from specific websites. ', 'sticky-buttons' ),
		],
		[
			'title' => __( 'Display Rules', 'sticky-buttons' ),
			'desc'  => __( 'Control exactly where your sticky buttons appear using page types, post categories/tags, author pages, taxonomies and date archives.', 'sticky-buttons' ),
			'link'  => 'https://share.cleanshot.com/RLXTk2Nr',
		],
		[
			'title' => __( 'Devices Rules', 'sticky-buttons' ),
			'desc'  => __( 'Ensure optimal menu visibility across all devices with options to hide/remove on specific screen sizes.', 'sticky-buttons' ),
			'link'  => 'https://share.cleanshot.com/X4hd6ybn',
		],
		[
			'title' => __( 'User Role Permissions', 'sticky-buttons' ),
			'desc'  => __( 'Define which user roles (e.g., Administrator, Editor, Author) have the ability to see the menu items. This can be helpful for displaying internal menus relevant only to website administrators or managing menus for specific user groups.', 'sticky-buttons' ),
			'link'  => 'https://share.cleanshot.com/b5M48z9G',
		],
		[
			'title' => __( 'Multilingual Support', 'sticky-buttons' ),
			'desc'  => __( 'For websites catering to a global audience, Sticky Buttons Pro allows you to restrict menu visibility to specific languages. This ensures users only see menus relevant to their chosen language setting. ', 'sticky-buttons' ),
			'link'  => 'https://share.cleanshot.com/KJdQh52J',
		],
        [
			'title' => __( 'Scheduling', 'sticky-buttons' ),
			'desc'  => __( 'Schedule button visibility by day, date, or time, perfect for running limited-time promotions or special events without permanent clutter. ', 'sticky-buttons' ),
		],
		[
			'title' => __( 'Browser Compatibility', 'sticky-buttons' ),
			'desc'  => __( 'Ensure your menus display correctly across a wide range of browsers. If necessary, you can choose to hide menus for specific browsers to address compatibility issues with outdated software versions.', 'sticky-buttons' ),
			'link'  => 'https://share.cleanshot.com/l0F31dVR',
		],
	],
];

?>

    <div class="wpie-block-tool is-white">

        <div class="wowp-pro-upgrade">
            <div>
                <h3>Unlock PRO Features</h3>
                <p>Upgrade to Sticky Buttons Pro and get advanced features like</p>
                <div class="buttons">
                    <a href="<?php echo esc_url( WOWP_Plugin::info( 'pro' ) ); ?>" target="_blank"
                       class="button button-primary">Get Sticky Buttons Pro</a>
                    <a href="<?php echo esc_url( WOWP_Plugin::info( 'demo' ) ); ?>" target="_blank" class="button-link">Try
                        Demo <span>→</span></a>
                </div>
            </div>
            <dl class="wowp-pro__profits">
                <div class="wowp-pro__profit">
                    <dt><span class="wpie-icon wpie_icon-money-time"></span>No Yearly Fees</dt>
                    <dd>One-time payment. Use it forever.</dd>
                </div>
                <div class="wowp-pro__profit">
                    <dt><span class="wpie-icon wpie_icon-refund"></span>14-Day Money-Back Guarantee</dt>
                    <dd>Try it risk-free. Get a full refund if you are not satisfied.</dd>
                </div>
                <div class="wowp-pro__profit">
                    <dt><span class="wpie-icon wpie_icon-cloud-data-sync"></span>Lifetime Free Updates</dt>
                    <dd>Always stay up to date for no extra cost.</dd>
                </div>
                <div class="wowp-pro__profit">
                    <dt><span class="wpie-icon wpie_icon-customer-support"></span>Priority Support</dt>
                    <dd>Fast, friendly, and expert help whenever you need it.</dd>
                </div>
            </dl>

        </div>

        <div class="wowp-pro-features">


            <h3 class="wpie-tabs">
				<?php
				$i = 0;
				foreach ( $features as $key => $feature ) {
					$class = ( $i === 0 ) ? ' selected' : '';
					$i ++;
					$name = str_replace( '-', ' ', $key );
					echo '<label class="wpie-tab-label' . esc_attr( $class ) . '" for="features-' . absint( $i ) . '">' . esc_html( ucwords( $name ) ) . '</label>';
				} ?>
            </h3>

            <div class="wpie-tabs-contents">

				<?php
				$i = 0;
				foreach ( $features as $key => $feature ) {
					$i ++;
					echo '<input type="radio" class="wpie-tab-toggle" name="features" value="1" id="features-' . absint( $i ) . '" ' . checked( 1, $i, false ) . '>';
					echo '<div class="wpie-tab-content">';
					echo '<dl>';
					foreach ( $feature as $value ) {
						echo '<div>';
						echo '<dt>' . esc_html( $value['title'] );

						if ( isset( $value['link'] ) ) {
							echo '<a href="' . esc_url( $value['link'] ) . '" target="_blank">How It Works <span class="wpie-icon wpie_icon-chevron-down"></span></a> ';
						}
						if ( isset( $value['demo'] ) ) {
							echo '<a href="' . esc_url( $value['demo'] ) . '" target="_blank">Try the Demo <span class="wpie-icon wpie_icon-chevron-down"></span></a>';
						}
						echo '</dt>';
						echo '<dd>' . esc_html( $value['desc'] ) . '</dd>';
						echo '</div>';
					}
					echo '</dl>';
					echo '</div>';
				} ?>


            </div>

        </div>

    </div>
<?php
