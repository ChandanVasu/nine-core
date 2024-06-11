jQuery(document).ready(function($) {
    var page = 2; // Start at page 2
    $('#load-more').on('click', function() {
        var data = {
            action: 'load_more',
            page: page,
            nonce: loadMoreParams.nonce
        };

        $.ajax({
            url: loadMoreParams.ajax_url,
            method: 'POST',
            data: data,
            beforeSend: function() {
                $('#load-more').text('Loading...'); // Change button text to "Loading..."
            },
            success: function(response) {
                if(response) {
                    $('.el-g-1-grid-container').append(response); // Append new posts
                    page++;
                    $('#load-more').text('Load More'); // Reset button text
                } else {
                    $('#load-more').hide(); // Hide button if no more posts
                }
            }
        });
    });
});
