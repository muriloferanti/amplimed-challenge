/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
/*!*****************************************!*\
  !*** ./resources/js/weather-records.js ***!
  \*****************************************/
__webpack_require__.r(__webpack_exports__);
$(document).ready(function () {
  $('#filter-text').on('keyup', function () {
    var value = $(this).val().toLowerCase();
    $('#records-table tr').filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
  function updateCharts(records) {
    $('html, body').animate({
      scrollTop: $('#charts-container').offset().top
    }, 1000);
    var ctx = $('#temperature-chart')[0].getContext('2d');
    var labels = records.map(function (record) {
      return "".concat(record.city, ", ").concat(record.country);
    });
    var temperatures = records.map(function (record) {
      return record.temperature;
    });
    var windSpeeds = records.map(function (record) {
      return record.wind_speed;
    });
    var humidities = records.map(function (record) {
      return record.humidity;
    });
    var cloudcovers = records.map(function (record) {
      return record.cloudcover;
    });
    var uvIndexes = records.map(function (record) {
      return record.uv_index;
    });
    if (window.temperatureChart) {
      window.temperatureChart.destroy();
    }
    window.temperatureChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Temperatura',
          data: temperatures,
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1,
          yAxisID: 'y1'
        }, {
          label: 'Velocidade do Vento',
          data: windSpeeds,
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1,
          yAxisID: 'y2'
        }, {
          label: 'Umidade',
          data: humidities,
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1,
          yAxisID: 'y3'
        }, {
          label: 'Cobertura de Nuvens',
          data: cloudcovers,
          backgroundColor: 'rgba(255, 206, 86, 0.2)',
          borderColor: 'rgba(255, 206, 86, 1)',
          borderWidth: 1,
          yAxisID: 'y4'
        }, {
          label: 'Índice UV',
          data: uvIndexes,
          backgroundColor: 'rgba(153, 102, 255, 0.2)',
          borderColor: 'rgba(153, 102, 255, 1)',
          borderWidth: 1,
          yAxisID: 'y5'
        }]
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
  $('.record-checkbox').change(function () {
    var selectedIds = $('.record-checkbox:checked').map(function () {
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
        success: function success(response) {
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
/******/ })()
;