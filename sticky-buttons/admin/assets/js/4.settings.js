'use strict';

jQuery(document).ready(function ($) {

    const selectors = {
        settings: '#wpie-settings',
        form_block: '.wpie-tabs-contents',
        color_picker: '.wpie-color',
        checkbox: '.wpie-field input[type="checkbox"]',
        full_editor: '.wpie-fulleditor',
        short_editor: '.wpie-texteditor',
        item_heading: '.wpie-item .wpie-item_heading',
        image_download: '.wpie-image-download',

        items_list: '.wpie-items__list',
        image_type: '[data-field="image_type"]',
        item: '#wpie-items-list .wpie-item',
        item_type: '[data-field="menu_1-item_type"]',
        custom_icon: '[data-field="menu_1-item_custom"]',
        text_icon: '[data-field="menu_1-item_custom_text_check"]',
        icon_text: '[data-field="menu_1-icon_text_on"]',

        enable_tracking: '[data-field="menu_1-enable_tracking"]',
        icon_color: '[data-field="menu_1-icon_custom_colors"]',
        label_color: '[data-field="menu_1-label_custom_colors"]',
        add_item: '.wpie-add-button',
        item_remove: '.wpie-item_heading .wpie_icon-trash',
        scroll: '[data-field="scroll"]',
        timer_action: '[data-field="timer_action"]',
        size: '[data-field="size"]',
        menu_type: '[data-field="position_type"]',
        item_duplicate: '.wpie-item_heading .wpie_icon-copy',
        delete_link: '.wpie-link-delete, .delete a',

    };


    function set_up() {
        $(selectors.full_editor).wowFullEditor();
        $(selectors.short_editor).wowTextEditor();

        $(selectors.color_picker).wpColorPicker({
            change: function (event, ui) {
                $(selectors.item).wowSideMenuLiveBuilder();
            },
        });

        $('.wp-picker-holder').on('click', function () {
            $(selectors.item).wowSideMenuLiveBuilder();
        });

        $(selectors.item).wowSideMenuLiveBuilder();

        $('.wpie-icon-box').wowIconPicker();

        const plugin_type = $('#wpie-settings input[name="plugin_type"]').val();


        $(selectors.items_list).sortable({
            items: '> .wpie-item',
            placeholder: "wpie-item ui-state-highlight",
            cancel: '.wpie-item_content',

            update: function (event, ui) {
                $(selectors.item).wowSideMenuLiveBuilder();
            },

            sort: function (event, ui) {
                if (plugin_type === 'pro') {
                    const offset = ui.position.left - ui.originalPosition.left;

                    const previousItem = ui.item.prev();
                    const previousMarginLeft = previousItem.length ? parseInt(previousItem.css("margin-left"), 10) || 0 : 0;

                    if (ui.item.is(':first-child')) {
                        ui.helper.css("margin-left", "0").removeClass("shifted-right");
                        return;
                    }

                    if (offset > 30) {
                        ui.helper.addClass("shifted-right");
                    }
                }

                if (typeof $(selectors.item).wowSideMenuLiveBuilder === "function") {
                    $(selectors.item).wowSideMenuLiveBuilder();
                }
            },

            stop: function (event, ui) {
                if (plugin_type === 'pro') {
                    const offset = ui.position.left - ui.originalPosition.left;

                    const previousItem = ui.item.prev();
                    const previousMarginLeft = previousItem.length ? parseInt(previousItem.css("margin-left"), 10) || 0 : 0;

                    if (ui.item.is(':first-child')) {
                        ui.item.css("margin-left", "0").removeClass("shifted-right");
                        return;
                    }

                    if (offset > 30) {
                        ui.item.css("margin-left", "30px").addClass("shifted-right");
                    } else {
                        ui.item.css("margin-left", "0").removeClass("shifted-right");
                    }
                }
                if (typeof $(selectors.item).wowSideMenuLiveBuilder === "function") {
                    $(selectors.item).wowSideMenuLiveBuilder();
                }
            }

        });

        $(selectors.items_list).disableSelection();

        $(selectors.color_picker).wpColorPicker();
        $(selectors.image_download).wowImageDownload();
        $(selectors.checkbox).each(set_checkbox);
        $(selectors.image_type).each(image_type);

        $(selectors.item_type).each(item_type);
        $(selectors.icon_text).each(icon_text);
        $(selectors.menu_type).each(menu_type);
        $(selectors.custom_icon).each(custom_icon);
        $(selectors.text_icon).each(custom_icon);
        $(selectors.enable_tracking).each(enable_tracking);

        $(selectors.scroll).each(scroll);
        $(selectors.timer_action).each(timer_action);
        $(selectors.size).each(size);
        $(selectors.icon_color).each(icon_color);
        $(selectors.label_color).each(label_color);

    }

    function initialize_events() {
        $(selectors.settings).on('change', selectors.checkbox, set_checkbox);
        $(selectors.settings).on('click', selectors.item_heading, item_toggle);

        $(selectors.settings).on('change', selectors.image_type, image_type);
        $(selectors.settings).on('change', selectors.icon_text, icon_text);
        $(selectors.settings).on('change', selectors.menu_type, menu_type);
        $(selectors.settings).on('change', selectors.item_type, item_type);

        $(selectors.settings).on('change', selectors.custom_icon, custom_icon);
        $(selectors.settings).on('change', selectors.text_icon, custom_icon);
        $(selectors.settings).on('change', selectors.enable_tracking, enable_tracking);
        $(selectors.settings).on('click', selectors.add_item, clone_button);
        $(selectors.settings).on('click', selectors.item_remove, item_remove);

        $(selectors.settings).on('change', selectors.scroll, scroll);
        $(selectors.settings).on('change', selectors.timer_action, timer_action);
        $(selectors.settings).on('change', selectors.size, size);
        $(selectors.settings).on('change', selectors.icon_color, icon_color);
        $(selectors.settings).on('change', selectors.label_color, label_color);
        $(selectors.settings).on('click', selectors.item_duplicate, item_duplicate);
        $(document).on('click', selectors.delete_link, delete_menu);


        $(selectors.settings).on('change click keyup', selectors.item, function () {
            $(selectors.item).wowSideMenuLiveBuilder();
        });

    }

    //region Main
    function initialize() {
        set_up();
        initialize_events();
        $(selectors.form_block).css('opacity', 1);
    }

    // Set the checkboxes
    function set_checkbox() {
        const next = $(this).next('input[type="hidden"]');
        if ($(this).is(':checked')) {
            next.val('1');
        } else {
            next.val('0');
        }
    }

    function item_toggle() {
        const parent = get_parent_fields($(this), '.wpie-item');
        const val = $(parent).attr('open') ? '0' : '1';
        $(parent).find('.wpie-item__toggle').val(val);
    }

    function get_parent_fields($el, $class = '.wpie-fields') {
        return $el.closest($class);
    }

    function get_field_box($el, $class = '.wpie-field') {
        return $el.closest($class);
    }

    //endregion

    //region Plugin

    function image_type() {
        const parent = get_parent_fields($(this));
        const box = get_field_box($(this));
        const type = $(this).val();
        const fields = parent.find('[data-field-box]').not(box);
        fields.addClass('is-hidden');

        const typeFieldMapping = {
            icon: ['menu_icon'],
            custom: ['herd_custom_link'],
            emoji: ['image_emoji'],
            class: ['image_emoji'],
        }

        if (typeFieldMapping[type]) {
            const fieldsToShow = typeFieldMapping[type];
            fieldsToShow.forEach(field => {
                parent.find(`[data-field-box="${field}"]`).removeClass('is-hidden');
            });
        }
    }

    function item_type() {
        const parent = get_parent_fields($(this));
        const box = get_field_box($(this));
        const type = $(this).val();
        const fields = parent.find('[data-field-box]').not(box);
        const parentTab = get_parent_fields($(this), '.wpie-tabs-wrapper');

        parentTab.find('.wpie-tab__link-popup').addClass('is-hidden');
        fields.addClass('is-hidden');

        const linkText = parent.find('[data-field-box="menu_1-item_link"] .wpie-field__title');
        linkText.text('Link');

        // Mapping menu types to the respective field boxes.
        const typeFieldMapping = {
            link: ['menu_1-item_link', 'menu_1-new_tab'],
            next_post: ['menu_1-new_tab'],
            previous_post: ['menu_1-new_tab'],
            share: ['menu_1-item_share'],
            translate: ['menu_1-gtranslate'],
            smoothscroll: ['menu_1-item_link'],
            scrollSpy: ['menu_1-item_link'],
            download: ['menu_1-item_link', 'menu_1-download'],
            login: ['menu_1-item_link'],
            logout: ['menu_1-item_link'],
            lostpassword: ['menu_1-item_link'],
            email: ['menu_1-item_link'],
            telephone: ['menu_1-item_link'],
            font: ['menu_1-font'],
            popover: [],
            skype_call: ['menu_1-item_link'],
            skype_chat: ['menu_1-item_link'],
            whatsapp_call: ['menu_1-item_link'],
            whatsapp_chat: ['menu_1-item_link'],
            viber_call: ['menu_1-item_link'],
            viber_chat: ['menu_1-item_link'],
            telegram_chat: ['menu_1-item_link'],
            imessage_chat: ['menu_1-item_link'],
            copyUrl: ['menu_1-item_link'],
            bookmark: ['menu_1-item_link'],
            play: ['menu_1-item_link'],
            pause: ['menu_1-item_link'],
            muted: ['menu_1-item_link'],
            loop: ['menu_1-item_link'],
            reset: ['menu_1-item_link'],
            volumeUp: ['menu_1-item_link'],
            volumeDown: ['menu_1-item_link'],
            function: ['menu_1-item_link'],
            favorite: ['menu_1-item_link'],
            copyText: ['menu_1-item_link', 'menu_1-selector'],
            share_content: ['menu_1-share_content', 'menu_1-selector'],
        };

        // Customize the link text for certain types
        const linkTextMapping = {
            login: 'Redirect URL',
            logout: 'Redirect URL',
            lostpassword: 'Redirect URL',
            email: 'Email',
            telephone: 'Phone number',
            download: 'File URL',
            skype_call: 'Username',
            skype_chat: 'Username',
            whatsapp_call: 'Phone number',
            whatsapp_chat: 'Phone number',
            viber_call: 'Phone number',
            viber_chat: 'Phone number',
            telegram_chat: 'Username',
            imessage_chat: 'Phone number',
            bookmark: 'Message',
            copyUrl: 'Message',
            play: 'Selector',
            pause: 'Selector',
            muted: 'Selector',
            loop: 'Selector',
            reset: 'Selector',
            volumeUp: 'Selector',
            volumeDown: 'Selector',
            function: 'Function Name',
            favorite: 'Label for Remove',
            copyText: 'Message',
        };

        if (type === 'popover')
            parentTab.find('.wpie-tab__link-popup').removeClass('is-hidden');

        else if (typeFieldMapping[type]) {
            const fieldsToShow = typeFieldMapping[type];
            fieldsToShow.forEach(field => {
                parent.find(`[data-field-box="${field}"]`).removeClass('is-hidden');
            });

            if (linkTextMapping[type]) {
                linkText.text(linkTextMapping[type]);
            }

        }
    }


    function custom_icon() {
        const fieldset = get_parent_fields($(this), '.wpie-fieldset');
        const parent_fields = get_parent_fields($(this));
        const neighborhood = fieldset.find('.wpie-fields').not(parent_fields).find('input[type="checkbox"]');
        const box = get_field_box($(this));
        const fields = parent_fields.find('[data-field-box]').not(box);
        fields.addClass('is-hidden');
        if ($(this).is(':checked')) {
            fields.removeClass('is-hidden');
            $(neighborhood).attr('disabled', 'disabled');
        } else {
            $(neighborhood).removeAttr('disabled');
        }
    }

    function icon_text() {
        const parent = get_parent_fields($(this));
        const box = get_field_box($(this));
        const fields = parent.find('[data-field-box="menu_1-icon_text_position"]');
        fields.addClass('is-hidden');
        if ($(this).is(':checked')) {
            fields.removeClass('is-hidden');
        }
    }

    function menu_type() {
        const parent = get_parent_fields($(this));
        const box = get_field_box($(this));
        const fields = parent.find('[data-field-box]').not(box);
        fields.addClass('is-hidden');
        if ($(this).val() === 'absolute' || $(this).val() === 'static') {
            fields.removeClass('is-hidden');
        }
    }

    // Scroll
    function scroll() {
        const type = $(this).val();
        const parent = get_parent_fields($(this));
        const box = get_field_box($(this));
        const fields = parent.find('[data-field-box]').not(box);
        fields.addClass('is-hidden');
        if (type !== '') {
            fields.removeClass('is-hidden');
        }
    }

    // Timer
    function timer_action() {
        const type = $(this).val();
        const parent = get_parent_fields($(this));
        const box = get_field_box($(this));
        const fields = parent.find('[data-field-box]').not(box);
        fields.addClass('is-hidden');
        if (type !== '') {
            fields.removeClass('is-hidden');
        }
    }

    function size() {
        const type = $(this).val();
        const parent = get_parent_fields($(this));
        const box = get_field_box($(this));
        const fields = parent.find('[data-field-box]').not(box);
        fields.addClass('is-hidden');
        if (type === '-custom') {
            fields.removeClass('is-hidden');
        }
    }

    function icon_color() {
        const parent = get_parent_fields($(this));
        const box = get_field_box($(this));
        const fields = parent.find('[data-field-box]').not(box);
        fields.addClass('is-hidden');
        if ($(this).is(':checked')) {
            fields.removeClass('is-hidden');
        }
    }

    function label_color() {
        const parent = get_parent_fields($(this));
        const box = get_field_box($(this));
        const fields = parent.find('[data-field-box]').not(box);
        fields.addClass('is-hidden');
        if ($(this).is(':checked')) {
            fields.removeClass('is-hidden');
        }
    }


    // Enable Event Tracking
    function enable_tracking() {
        const fieldset = get_parent_fields($(this), '.wpie-fieldset');
        const tracking_field = fieldset.find('.wpie-fields').eq(1);
        tracking_field.addClass('is-hidden');
        if ($(this).is(':checked')) {
            tracking_field.removeClass('is-hidden');
        }
    }


    function item_remove() {
        const userConfirmed = confirm("Are you sure you want to remove this element?");
        if (userConfirmed) {
            const parent = $(this).closest('.wpie-item');
            $(parent).remove();
        }
    }

    function item_duplicate() {
        const userConfirmed = confirm("Do you want to duplicate this element?");
        if (userConfirmed) {
            const parent = get_parent_fields($(this), '.wpie-items__list');
            const item = $(this).closest('.wpie-item');

            let selectedValues = {};
            item.find('select').each(function () {
                selectedValues[$(this).attr('name')] = $(this).val();
            });

            $(item).attr('open', 'false');
            const clonedItem = item.clone(true, true);
            cleaningItem(clonedItem);

            clonedItem.find('select').each(function () {
                let name = $(this).attr('name');
                if (selectedValues[name]) {
                    $(this).val(selectedValues[name]);
                }
            });

            $(clonedItem).attr('open', '');
            item.after(clonedItem);
            set_up();
        }
    }

    function cleaningItem(item) {

        $(item).find('select').each(function () {
            let selectedValue = $(this).val();
        });

        $(item).find('.wpie-fulleditor').each(function () {
            const field = $(this);
            const id = $(this).attr('id');
            field.removeAttr('style id aria-hidden');
            const parent = $(this).closest('.wpie-field__label');
            const editor = $(parent).find('.wp-editor-wrap');
            if (editor.hasClass('tmce-active')) {
                let content = tinyMCE.get(id)?.getContent();
                field.val(content);
            }
            $(editor).remove();
            $(parent).prepend(field);
        });

        $(item).find('.wpie-color').each(function () {
            const field = $(this);
            field.removeAttr('style');
            const parent = $(this).closest('.wpie-field');
            const picker = $(parent).find('.wp-picker-container');
            $(picker).remove();
            $(parent).append(field);
        });

        $(item).find('.wpie-icon-box').each(function () {
            const field = $(this);
            field.removeAttr('style');
            let $this = $(this);

            // Видаляємо збережені дані плагіна
            $this.removeData('fontIconPicker');

            // Видаляємо додані DOM-елементи (панель вибору)
            $this.siblings('.fip-box').remove();

            // Видаляємо додані класи
            $this.removeClass('fip fip-theme-darkgrey');

            // Відновлюємо оригінальний <select>
            $this.show();

            const parent = $(this).closest('.wpie-field__label');
            const picker = $(parent).find('.icons-selector');
            $(picker).remove();
        });

    }

    function delete_menu(e) {
        const proceed = confirm("Are you sure want to Delete Menu?");
        if (!proceed) {
            e.preventDefault();
        }
    }


    // Clone menu item
    function clone_button(e) {
        e.preventDefault();
        const parent = get_parent_fields($(this), '.wpie-items__list');
        const selector = $(parent).find('.wpie-buttons__hr');
        const template = $('#template-button').clone().html();

        $(template).insertBefore($(selector));

        set_up();
    }


    initialize();
});