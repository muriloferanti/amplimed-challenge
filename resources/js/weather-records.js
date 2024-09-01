$(document).ready(function() {
    $('#filter-text').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#records-table tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });


    function updateCharts(records) {
        $('html, body').animate({
            scrollTop: $('#charts-container').offset().top
        }, 1000);
        
        const ctx = $('#temperature-chart')[0].getContext('2d');
    
        const labels = records.map(record => `${record.city}, ${record.country}`);
        const temperatures = records.map(record => record.temperature);
        const windSpeeds = records.map(record => record.wind_speed);
        const humidities = records.map(record => record.humidity);
        const cloudcovers = records.map(record => record.cloudcover);
        const uvIndexes = records.map(record => record.uv_index);
    
        if (window.temperatureChart) {
            window.temperatureChart.destroy();
        }
    
        window.temperatureChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Temperatura',
                        data: temperatures,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        yAxisID: 'y1'
                    },
                    {
                        label: 'Velocidade do Vento',
                        data: windSpeeds,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        yAxisID: 'y2'
                    },
                    {
                        label: 'Umidade',
                        data: humidities,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        yAxisID: 'y3'
                    },
                    {
                        label: 'Cobertura de Nuvens',
                        data: cloudcovers,
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1,
                        yAxisID: 'y4'
                    },
                    {
                        label: 'Índice UV',
                        data: uvIndexes,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1,
                        yAxisID: 'y5'
                    }
                ]
            },
            options: {
                scales: {
                    y1: {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Temperatura (°C)'
                        }
                    },
                    y2: {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: 'Velocidade do Vento (km/h)'
                        }
                    },
                    y3: {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: 'Umidade (%)'
                        }
                    },
                    y4: {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: 'Cobertura de Nuvens (%)'
                        }
                    },
                    y5: {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false
                        },
                        title: {
                            display: true,
                            text: 'Índice UV'
                        }
                    }
                }
            }
        });
    }
    

    $('.record-checkbox').change(function() {
        const selectedIds = $('.record-checkbox:checked').map(function() {
            return $(this).data('id');
        }).get();

        if (selectedIds.length > 0) {
            $.ajax({
                url: '/weather-compare',
                method: 'GET',
                data: {
                    ids: selectedIds,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#charts-container').show();
                        updateCharts(response.records);
                    } else {
                        $('#charts-container').hide();
                        alert('Erro ao obter dados.');
                    }
                }
            });
        } else {
            $('#charts-container').hide();
        }
    });
});
