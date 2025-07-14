'use strict';
(function ($) {

    $.fn.wowSideMenuLiveBuilder = function () {
        this.each(function (index, element) {
            const labelText = $(this).find('[data-field="menu_1-item_tooltip"]').val();
            let typeText = $(this).find('[data-field="menu_1-item_type"] option:selected').text();
            // const subItem = $(this).find('[data-field="menu_1-sub_item"]');
            const linkType = $(this).find('[data-field="menu_1-item_type"]').val();
            const iconValue = getIcon(this);

            const icon = $(this).find('.wpie-item_heading_icon');
            const label = $(this).find('.wpie-item_heading_label');
            const type = $(this).find('.wpie-item_heading_type');
            // const sub = $(this).find('.wpie-item_heading_sub');

            if (linkType === 'share') {
                const text = $(this).find('[data-field="menu_1-item_share"] option:selected').text();
                typeText = typeText + ': ' + text;
            }

            if (linkType === 'share_content') {
                const text = $(this).find('[data-field="menu_1-share_content"] option:selected').text();
                typeText = typeText + ': ' + text;
            }

            if (linkType === 'translate') {
                const text = $(this).find('[data-field="menu_1-gtranslate"] option:selected').text();
                typeText = typeText + ': ' + text;
            }

            if (linkType === 'smoothscroll') {
                const text = $(this).find('[data-field="menu_1-item_link"]').val();
                typeText = typeText + ': ' + text;
            }

            if (linkType === 'font') {
                const text = $(this).find('[data-field="menu_1-font"] option:selected').text();
                typeText = typeText + ': ' + text;
            }


            const sub = $(element).find('.wpie-item__parent');

            if ($(element).hasClass('shifted-right')) {
                sub.val(1);
            } else {
                sub.val(0);
            }

            const color = $(this).find('[data-field="menu_1-color"]').val();
            const bcolor = $(this).find('[data-field="menu_1-bcolor"]').val();
            const font = $(this).find('[data-field="menu_1-label_font"]').val();
            const style = $(this).find('[data-field="menu_1-label_style"]').val();
            const weight = $(this).find('[data-field="menu_1-label_weight"]').val();

            icon.css({'color': color, 'background': bcolor});

            label.css({
                'color': color,
                'background': bcolor,
                'font-family': font,
                'font-style': style,
                'font-weight': weight
            });

            icon.add(label).hover(
                function () { // This runs when the mouse enters either the icon or label
                    icon.css({'color': bcolor, 'background': color});
                    label.css({'color': bcolor, 'background': color});
                },
                function () { // This runs when the mouse leaves either the icon or label
                    icon.css({'color': color, 'background': bcolor});
                    label.css({'color': color, 'background': bcolor});
                }
            );


            label.text(labelText);
            type.text(typeText);
            icon.html(iconValue);


        });

        function getIcon(element) {

            const custom_text = $(element).find('[data-field="menu_1-item_custom_text_check"]');
            const item_custom = $(element).find('[data-field="menu_1-item_custom"]');
            if ($(custom_text).is(':checked')) {
                return $(element).find('[data-field="menu_1-item_custom_text"]').val();
            }

            if ($(item_custom).is(':checked')) {
                const icon_custom = $(element).find('[data-field="menu_1-item_custom_link"]').val();
                if (isValidURL(icon_custom)) {
                    return `<img src="${icon_custom}">`;
                } else {
                    return `<span class="dashicons dashicons-camera-alt"></span>`;
                }
            }
            let icon = $(element).find('[data-field="menu_1-item_icon"]').val();
            return `<span class="${icon}"></span>`;

        }

        function isValidURL(string) {
            var regex = new RegExp(
                '^(https?:\\/\\/)?' + // protocol
                '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
                '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
                '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
                '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
                '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
            return !!regex.test(string);
        }
    }

}(jQuery));