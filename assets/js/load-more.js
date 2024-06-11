jQuery(document).ready(function($) {
    $(document).on('click', '.el-g-1-load-more-button', function() {
        var button = $(this);
        var page = button.data('page');
        var settings = button.data('settings');
        var container = $('#' + settings.uuid + ' .el-g-1-grid-container');

        $.ajax({
            url: ajaxurl,  // This is a variable automatically defined by WordPress
            type: 'POST',
            data: {
                action: 'load_more_posts',
                page: page,
                settings: settings
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
});
