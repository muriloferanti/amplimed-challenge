$(document).ready(function() {
    function getLocationFromUrl() {
        const path = window.location.pathname;
        const segments = path.split('/');
        return segments[segments.length - 1];
    }

    const location = getLocationFromUrl();

    $('#save-weather').on('click', function() {
        $.ajax({
            url: `/weather-records/${location}`,
            method: 'POST',
            data: {
                location: location,
                _token: $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(response) {
                $('#message').html(`<div class="text-success">${response.message}</div>`);
            },
            error: function(xhr) {
                $('#message').html(`<div class="text-danger">${xhr.responseJSON.message}</div>`);
            }
        });
    });
});
