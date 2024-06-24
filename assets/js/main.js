jQuery(document).ready(function($) {
    // Load More Button Functionality
    $(document).on('click', '.load-more-button', function() {
        var button = $(this);
        var page = button.data('page');
        var settings = button.data('settings');
        var nonce = button.data('nonce');
        var container = $('#' + settings.uuid + ' .el-g-1-grid-container');

        $.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'load_more_posts',
                page: page,
                settings: settings,
                nonce: nonce
            },
            beforeSend: function() {
                button.text('Loading...');
            },
            success: function(response) {
                if (response) {
                    container.append(response);
                    button.data('page', page + 1);
                    button.text('Load More');
                } else {
                    button.text('No More Posts').prop('disabled', true);
                }
            }
        });
    });

    // Search Overlay
    $('.search-icon-link').click(function(event) {
        event.preventDefault();
        $('#search-overlay').css('height', '100%');
    });

    $('#close-search').click(function() {
        $('#search-overlay').css('height', '0');
    });

    // Navigation Menu Toggle (if navigation menu widget is present)
    if ($('.el-menu-icon-wrapper').length) {
        $('.el-menu-icon-wrapper').click(function(event) {
            $('.el-nav-menu-wrapper').addClass('visible');
            $('.el-nav-menu-box').addClass('overlay-box');
        });

        $('.el-close-icon-wrapper').click(function(event) {
            $('.el-nav-menu-wrapper').removeClass('visible');
            $('.el-nav-menu-box').removeClass('overlay-box');
        });
    }
});


