'use strict';
(function ($) {

    $.fn.wowSideMenuLiveBuilder = function () {
        this.each(function (index, element) {
            const labelText = $(this).find('[data-field="menu_1-item_tooltip"]').val();
            const typeText = $(this).find('[data-field="menu_1-item_type"] option:selected').text();
            const subItem = $(this).find('[data-field="menu_1-sub_item"]');
            const iconValue = getIcon(this);

            const icon = $(this).find('.wpie-item_heading_icon');
            const label = $(this).find('.wpie-item_heading_label');
            const type = $(this).find('.wpie-item_heading_type');
            const sub = $(this).find('.wpie-item_heading_sub');

            const color = $(this).find('[data-field="menu_1-color"]').val();
            const iconcolor = $(this).find('[data-field="menu_1-iconcolor"]').val();
            const bcolor = $(this).find('[data-field="menu_1-bcolor"]').val();
            const hbcolor = $(this).find('[data-field="menu_1-hbcolor"]').val();
            const font = $(this).find('[data-field="menu_1-item_tooltip_font"]').val();
            const style = $(this).find('[data-field="menu_1-item_tooltip_style"]').val();
            const weight = $(this).find('[data-field="menu_1-item_tooltip_weight"]').val();

            icon.css({'color': iconcolor, 'background': bcolor});
            label.css({
                'color': color,
                'background': bcolor,
                'font-family': font,
                'font-style': style,
                'font-weight': weight
            });

            icon.add(label).hover(
                function () { // This runs when the mouse enters either the icon or label
                    icon.css({'color': iconcolor, 'background': hbcolor});
                    label.css({'color': color, 'background': hbcolor});
                },
                function () { // This runs when the mouse leaves either the icon or label
                    icon.css({'color': color, 'background': bcolor});
                    label.css({'color': color, 'background': bcolor});
                }
            );


            label.text(labelText);
            type.text(typeText);
            if (subItem.is(':checked')) {
                sub.html('<em>sub item</em>');
            } else {
                sub.html('');
            }
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