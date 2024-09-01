$(document).ready(function() {
    $('.weather-zip-code').on('change', function() {
        let zipCode = $(this).val().replace(/\D/g, '');
        if (zipCode.length === 8) { 
            $.ajax({
                url: `/zip-code/${zipCode}`,
                method: 'GET',
                beforeSend: function() {
                    $('#weather-search #city, #weather-search button').attr('disabled', 'disable');
                },
                success: function(response) {
                    $('.text-danger').remove();
                    if (response.city) {
                        $('#city').val(response.city);
                    }
                },
                error: function(xhr) {
                    $('<span id="zip-code-error" class="text-danger">CEP inválido</span>').insertAfter('.weather-zip-code');
                },
                complete: function() {
                    $('#weather-search #city, #weather-search button').removeAttr('disabled');
                }
            });
        }
    });

    $('#weather-search').on('submit', function(event) {
        event.preventDefault(); 
    
        let city = $('#city').val();

        let formattedCity = normalizeCityName(city);

        window.location.href = `/weather/${formattedCity}`;
    });
   
    function normalizeCityName(cityName) {
        return cityName.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().replace(/\s+/g, '-');
    }
});
