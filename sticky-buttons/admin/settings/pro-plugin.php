<?php

use FloatMenuLite\WOWP_Plugin;

defined( 'ABSPATH' ) || exit;

$default = $options['item_order']['pro_feature'] ?? 1;
$item_order = ! empty( $default ) ? 1 : 0;
$open = ! empty( $item_order ) ? ' open' : '';
?>

<div class="wpie-sidebar wpie-sidebar-features">
    <details class="wpie-item"<?php
	echo esc_attr( $open ); ?>>
        <input type="hidden" name="param[item_order][pro_feature]" class="wpie-item__toggle" value="<?php
		echo absint( $item_order ); ?>">
        <summary class="wpie-item_heading">
            <span class="wpie-item_heading_icon"><span
                        class="wpie-icon wpie_icon-rocket wpie-color-danger"></span></span>
            <span class="wpie-item_heading_label"><?php
				esc_html_e( 'PRO FEATURES', 'side-menu-lite' ); ?></span>
            <span class="wpie-item_heading_type"></span>
            <span class="wpie-item_heading_toogle">
                <span class="wpie-icon wpie_icon-chevron-down"></span>
                <span class="wpie-icon wpie_icon-chevron-up "></span>
            </span>
        </summary>
        <div class="wpie-fields__box">

            <h4>Interface Options</h4>

            <details class="wpie-details-sidebar">
                <summary>Hold Label open</summary>
                <p>
                    When enabled, the "Hold Open" option ensures that the menu label (the text representing the
                    menu) remains visible at all times, even when the user hovers away from the menu itself. </p>
            </details>
            <details class="wpie-details-sidebar">
                <summary>Hide/Show</summary>
                <div class="wpie-details-sidebar-box">
                    <ul>
                        <li><strong>Show After Position:</strong> Control when the menu becomes visible after the user
                            scrolls down the page (in pixels).
                        </li>
                        <li><strong>Hide After Position:</strong> Control when the menu hides as the user scrolls up the
                            page (in pixels).
                        </li>
                        <li><strong>Timer for display:</strong> Set the delay for when the menu should be shown on the page after it loads.
                        </li>
                        <li><strong>Timer for hide:</strong> Utilize the hide timer functionality to initially hide the menu when the page loads.
                        </li>
                    </ul>
                </div>

            </details>
            <details class="wpie-details-sidebar">
                <summary>Icons</summary>
                <div class="wpie-details-sidebar-box">
                    <ul>
                        <li><strong>Set Font Awesome Icon:</strong> Choose an icon from the Font Awesome library and
                            optionally set an animation for the icon.
                        </li>
                        <li><strong>Custom Icon:</strong> Set a custom icon using a URL to the image or by defining a
                            class
                            for the icon if you're using a font icon set other than Font Awesome.
                        </li>
                        <li><strong>Text:</strong> Use a letter or emoji as the icon. This can be a great alternative to
                            Font Awesome icons.
                        </li>
                        <li><strong>Icon Animations:</strong> Select from 7 sophisticated icon animations for each button default icon.
                        </li>

                    </ul>
                </div>
            </details>




            <h4>Content Management </h4>
            <details class="wpie-details-sidebar">
                <summary>Item Types</summary>
                <div class="wpie-details-sidebar-box">
                    <ul>
                        <li><strong>Link:</strong> Create a link to any page on your website. You can also choose to
                            open
                            the link in a new window.
                        </li>
                        <li><strong>Next Post:</strong> Generate a link to the next post within the current post's
                            category.
                        </li>
                        <li><strong>Previous Post:</strong> Generate a link to the previous post within the current
                            post's
                            category.
                        </li>
                        <li><strong>Share:</strong> Create a link with sharing options for social media. Choose from 29
                            different social media services.
                        </li>
                        <li><strong>Translate:</strong> Offer your users the ability to translate your page in
                            real-time.
                        </li>
                        <li><strong>ScrollSpy:</strong> With Scrollspy functionality, visitors can easily navigate through different sections of the page.
                        </li>
                        <li><strong>Download:</strong> Create a menu item with a force download file.</li>
                        <li><strong>Print:</strong> Provide a link for printing the current page.</li>
                        <li><strong>Popup:</strong> Generate a link that opens a popup created by the plugin.</li>
                        <li><strong>Font Size:</strong> Adjust the zoom level of the entire page.</li>
                        <li><strong>Bookmark:</strong> Add the current page to bookmarks.</li>
                        <li><strong>Copy URL:</strong> Copy the page URL to the clipboard, making it easier for users to share manually.</li>
                        <li><strong>Scroll To Top:</strong> Create a smooth-scrolling link that takes users to the top of the page.
                        </li>
                        <li><strong>Scroll To Bottom:</strong> Create a smooth-scrolling link that takes users to the
                            bottom
                            of the page.
                        </li>
                        <li><strong>Smooth Scroll:</strong> Enable this option for a more pleasant user experience when
                            navigating a page with anchor links.
                        </li>
                        <li><strong>Go Back:</strong> Allow users to navigate back to the previous page in their browser
                            history.
                        </li>
                        <li><strong>Go Forward:</strong> Create a link to the next page in the user's browser history.
                        </li>
                        <li><strong>Email:</strong> Generate a quick link that opens the user's email client to compose
                            a
                            new email addressed to a specific address you define.
                        </li>
                        <li><strong>Telephone:</strong> Create a link that allows users to call a specific phone number.
                        </li>
                        <li><strong>Login:</strong> Create a link to your site's login page.</li>
                        <li><strong>Logout:</strong> Create a link for users to log out if they are currently logged in.
                        </li>
                        <li><strong>Lost Password:</strong> Create a link to the password reset page for users.</li>
                        <li><strong>Register:</strong> Create a link to the user registration page on your site.</li>

                    </ul>
                </div>

            </details>


            <h4>Display Rules and Visibility</h4>
            <details class="wpie-details-sidebar">
                <summary>Display Rules</summary>
                <div class="wpie-details-sidebar-box">
                    <p>Control exactly where your menus appear using shortcodes, page types, post categories/tags,
                        author
                        pages, and date archives.</p>
                </div>
            </details>
            <details class="wpie-details-sidebar">
                <summary>Devices Rules</summary>
                <div class="wpie-details-sidebar-box">
                    <p>Ensure optimal menu visibility across all devices with options to hide/remove on specific screen sizes. Remove on Mobile, Remove on Desktop</p>
                </div>

            </details>

            <details class="wpie-details-sidebar">
                <summary>Hide Based on Browser</summary>
                <div class="wpie-details-sidebar-box">
                    Customize the visibility of your menus depending on the user's browser. Selectively hide
                    menu for specific browsers to ensure compatibility and enhance user experience across different
                    web environments.
                </div>
            </details>

            <h4>User Permissions and Targeting</h4>

            <details class="wpie-details-sidebar">
                <summary>Permissions of Users</summary>
                <div class="wpie-details-sidebar-box">
                    Set specific permissions for displaying menus based on user roles. Customize which user
                    groups (e.g., Administrators, Editors, Authors) can view or interact with your menus, ensuring
                    relevant content reaches the appropriate audience.
                </div>

            </details>

            <details class="wpie-details-sidebar">
                <summary>URL contain</summary>
                <div class="wpie-details-sidebar-box">
                    Trigger the menu to display if the URL contains a specific parameter, such as menu=active,
                    allowing targeted content delivery based on URL parameters.
                </div>
            </details>

            <details class="wpie-details-sidebar">
                <summary>URL is Referrer</summary>
                <div class="wpie-details-sidebar-box">
                    Customize menu experiences for visitors arriving from specific websites, such as displaying
                    a welcome message for users coming from a partner site.
                </div>
            </details>

            <details class="wpie-details-sidebar">
                <summary>Multi Language</summary>
                <div class="wpie-details-sidebar-box">
                    For websites catering to a global audience, Float Menu Pro allows you to restrict menu
                    visibility to
                    specific languages. This ensures users only see menus relevant to their chosen language
                    setting.
                </div>
            </details>

            <details class="wpie-details-sidebar">
                <summary>Scheduling</summary>
                <div class="wpie-details-sidebar-box">
                    <p>Schedule menu appearances based on specific days, times, and dates. This allows you to promote
                        temporary events or campaigns without cluttering your website permanently.</p>
                </div>

            </details>
        </div>

    </details>

    <div class="wpie-buttons">
        <a href="https://demo.wow-estore.com/sticky-buttons-pro/" target="_blank" class="wpie-button is-demo">Demo</a>
        <a href="https://wow-estore.com/item/sticky-buttons-pro/" target="_blank" class="wpie-button is-pro">GET PRO</a>
    </div>
</div>
