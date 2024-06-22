jQuery(document).ready(function($) {
    $(document).on('click', '.load-more-button', function() {
        var button = $(this);
        var page = button.data('page');
        var settings = button.data('settings');
        var nonce = button.data('nonce');
        var container = $('#' + settings.uuid + ' .el-g-1-grid-container');

        $.ajax({
            url: ajaxurl,  // This is a variable automatically defined by WordPress
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
});

document.querySelector('.search-icon-link').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('search-overlay').style.height = '100%';
});
document.getElementById('close-search').addEventListener('click', function() {
    document.getElementById('search-overlay').style.height = '0';
});


