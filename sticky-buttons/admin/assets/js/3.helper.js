'use strict'

jQuery(document).ready(function ($) {

    $.fn.wowFullEditor = function () {

        this.each(function (index, element) {
            const newId = 'wpie-fulleditor-' + (index + 1);
            $(element).attr('id', newId);
            $(element).css({'border': 'none', 'width': '100%'});
                wp.editor.initialize(
                    newId,
                    {
                        tinymce: {
                            wpautop: false,
                            plugins: 'lists wplink hr charmap textcolor colorpicker paste tabfocus wordpress wpautoresize wpeditimage wpemoji wpgallery wplink wptextpattern codemirror table',
                            toolbar1: 'bold italic underline subscript superscript blockquote | bullist numlist | alignleft aligncenter alignright alignjustify | link unlink | wp_adv',
                            toolbar2: 'strikethrough hr | forecolor backcolor | pastetext removeformat charmap | outdent indent | undo redo wp_help ',
                            toolbar3: 'formatselect fontselect fontsizeselect | table',
                        },
                        quicktags: {
                            buttons: "strong,em,link,block,del,ins,img,ul,ol,li,code,more,close",
                        },
                        mediaButtons: false,
                    }
                );
        });
    };

    $.fn.wowTextEditor = function () {
        this.each(function (index, element) {
            const newId = 'wpie-shorteditor-' + (index + 1);
            $(element).attr('id', newId);
            $(element).css({'border-top': 'none', 'min-height': '2'});

            wp.editor.initialize(newId, {
                tinymce: false, // This disables Visual mode
                quicktags: {
                    buttons: "strong,em,link,block,del,ins,img,ul,ol,li,code,more,close,fullscreen"
                },
                mediaButtons: false,
            });
        });
    };

    $.fn.wowIconPicker = function () {
        this.fontIconPicker({
            theme: 'fip-darkgrey',
            emptyIcon: false,
            allCategoryText: 'Show all',
        });
    };

    $.fn.wowImageDownload = function (){
        const input = $(this).find('input');
        const addon = $(this).find('.wpie-field__label.is-addon');
        $(addon).html('<span class="wpie-icon wpie_icon-file-download is-pointer"></span>');
        var custom_uploader;

        $(addon).on('click', function (e){
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }

            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false  // Set to true to allow multiple files to be selected
            });

            // When an image is selected in the media manager...
            custom_uploader.on('select', function() {
                // Get media attachment details from the frame state
                var attachment = custom_uploader.state().get('selection').first().toJSON();

                // Send the attachment URL to our custom input field.
                $(input).val(attachment.url);
            });

            // Open the media manager.
            custom_uploader.open();
        });

    };


});