import $ from 'jquery';
window.$ = window.jQuery = $;

$(document).ready(function() {
    menu();
    homeForm();
    list();

    $(window).resize(function() {
        list();
    });

    function homeForm() {
        $('.input-zip-code').on('input', function() {
            let zipCode = $(this).val().replace(/\D/g, '');
            if (zipCode.length <= 5) {
                $(this).val(zipCode);
            } else {
                $(this).val(zipCode.slice(0, 5) + '-' + zipCode.slice(5, 8));
            }
        });
    }

    function menu() {
        function closeMenu() {
            $('#side-menu').removeClass('open');
        }

        $('#hamburger').click(function(){
            $('#side-menu').toggleClass('open');
        });

        $('#close-menu').click(function(){
            closeMenu();
        });

        $(document).keyup(function(e) {
            if (e.key === "Escape") { 
                closeMenu();
            }
        });

        $(document).click(function(e) {
            if (!$(e.target).closest('#side-menu, #hamburger').length) {
                closeMenu();
            }
        });

        window.addEventListener('popstate', function() {
            closeMenu();
        });
    }

    function list() {
        if ($(window).width() > 768) {
            $.ajax({
                url: '/weather-records-latest',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        const $elementList = $('#global-weather');
                        const records = response.records;
                        const itemContent = records.map(record => 
                            `<div class="item">
                                <span class="city">${record.city}</span> 
                                <div>
                                    <p class="temperature">${record.temperature}°C</p> 
                                    <div>
                                        <p class="wind-speed">Vento: ${record.wind_speed} km/h</p> 
                                        <p class="date">${new Date(record.saved_at).toLocaleDateString()}</p>
                                    </div>
                                </div>
                            </div>
                            `
                        ).join(''); 
        
                        $elementList.html(itemContent);
                    } else {
                        console.error('Erro ao obter dados.');
                    }
                },
                error: function() {
                    console.error('Erro na requisição AJAX.');
                }
            });
        } else {
            $('#global-weather').html('');
        }
    }
});
