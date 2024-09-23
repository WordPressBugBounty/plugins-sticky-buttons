'use strict';

jQuery(document).ready(function ($) {

    const selectors = {
        settings: '#wpie-settings',
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
        enable_tracking: '[data-field="menu_1-enable_tracking"]',
        add_item: '.wpie-add-button',
        item_remove: '.wpie-item_heading .wpie_icon-trash',
        scroll: '[data-field="scroll"]',
        timer_action: '[data-field="timer_action"]',

    };


    function set_up() {
        $(selectors.full_editor).wowFullEditor();
        $(selectors.short_editor).wowTextEditor();

        $(selectors.color_picker).wpColorPicker({
            change: function(event, ui){ $(selectors.item).wowSideMenuLiveBuilder(); },
        });
        $(selectors.item).wowSideMenuLiveBuilder();

        $('.wpie-icon-box select').fontIconPicker({
            theme: 'fip-darkgrey', emptyIcon: false, allCategoryText: 'Show all',
        });

        $(selectors.items_list).sortable({
            items: '> .wpie-item',
            placeholder: "wpie-item ui-state-highlight",
            update: function(event, ui) {

            }
        });
        $(selectors.items_list).disableSelection();

        $(selectors.color_picker).wpColorPicker();
        $(selectors.image_download).wowImageDownload();
        $(selectors.checkbox).each(set_checkbox);
        $(selectors.image_type).each(image_type);

        $(selectors.item_type).each(item_type);
        $(selectors.custom_icon).each(custom_icon);
        $(selectors.text_icon).each(custom_icon);
        $(selectors.enable_tracking).each(enable_tracking);

        $(selectors.scroll).each(scroll);
        $(selectors.timer_action).each(timer_action);

    }

    function initialize_events() {
        $(selectors.settings).on('change', selectors.checkbox, set_checkbox);
        $(selectors.settings).on('click', selectors.item_heading, item_toggle);

        $(selectors.settings).on('change', selectors.image_type, image_type);
        $(selectors.settings).on('change', selectors.item_type, item_type);

        $(selectors.settings).on('change', selectors.custom_icon, custom_icon);
        $(selectors.settings).on('change', selectors.text_icon, custom_icon);
        $(selectors.settings).on('change', selectors.enable_tracking, enable_tracking);
        $(selectors.settings).on('click', selectors.add_item, clone_button);
        $(selectors.settings).on('click', selectors.item_remove, item_remove);

        $(selectors.settings).on('change', selectors.scroll, scroll);
        $(selectors.settings).on('change', selectors.timer_action, timer_action);

        $(selectors.settings).on('change click keyup', selectors.item, function (){
            $(selectors.item).wowSideMenuLiveBuilder();
        });

    }

    //region Main
    function initialize() {
        set_up();
        initialize_events();
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

        parentTab.find('.wpie-tab__type-menu').addClass('is-hidden');
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
            popover: []
        };

        // Customize the link text for certain types
        const linkTextMapping = {
            login: 'Redirect URL',
            logout: 'Redirect URL',
            lostpassword: 'Redirect URL',
            email: 'Email',
            telephone: 'Telephone',
            download: 'File URL'
        };

        if (type === 'popover')
            parentTab.find('.wpie-tab__type-menu').removeClass('is-hidden');

        else if (typeFieldMapping[type]) {
            const fieldsToShow = typeFieldMapping[type];
            fieldsToShow.forEach(field => {
                parent.find(`[data-field-box="${field}"]`).removeClass('is-hidden');
            });

            if (linkTextMapping[type])
                linkText.text(linkTextMapping[type]);
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

    // Scroll
    function scroll() {
        const type = $(this).val();
        const parent = get_parent_fields($(this));
        const box = get_field_box($(this));
        const fields = parent.find('[data-field-box]').not(box);
        fields.addClass('is-hidden');
        if(type !== '') {
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
        if(type !== '') {
            fields.removeClass('is-hidden');
        }
    }

    // Enable Event Tracking
    function enable_tracking() {
        const fieldset = get_parent_fields($(this), '.wpie-fieldset');
        const tracking_field = fieldset.find('.wpie-event-tracking');
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