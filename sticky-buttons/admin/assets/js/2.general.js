'use strict'

jQuery(document).ready(function($) {


    $(document).on('keydown', function(event) {
        if ((event.key === 's' || event.key === 'S') && (event.metaKey || event.ctrlKey)) {
            event.preventDefault();
            const button = document.getElementById('submit_settings');
            button.click();
        }
    });



    $('.wpie-tabs').on('click', '.wpie-tab-label', function() {
        $('.wpie-tabs .wpie-tab-label').removeClass('selected');
        $(this).addClass('selected');
    });

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('notice')) {
        const notice = $('.wpie-notice');
        $(notice).addClass('is-active');
        setTimeout(function (){
            $(notice).removeClass('is-active');
        }, 5000);
    }

    $('.wpie-link-delete, .delete a').on('click', function (e){
        const proceed = confirm("Are you sure want to Delete Menu?");
        if(!proceed) {
            e.preventDefault();
        }
    });

    $('.wpie-settings__main').on('click', '.wpie-tab__link', function (){
        const parent = $(this).closest('.wpie-tabs-wrapper');
        const links = $(parent).find('.wpie-tab__link');
        const settings = $(parent).find('.wpie-tab-settings');
        const index = $(links).index(this);

        $(links).removeClass('is-active');
        $(this).addClass('is-active');
        $(settings).removeClass('is-active');
        $(settings).eq(index).addClass('is-active');
    });

});