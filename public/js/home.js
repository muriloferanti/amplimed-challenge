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
/*!******************************!*\
  !*** ./resources/js/home.js ***!
  \******************************/
__webpack_require__.r(__webpack_exports__);
$(document).ready(function () {
  $('.weather-zip-code').on('change', function () {
    var zipCode = $(this).val().replace(/\D/g, '');
    if (zipCode.length === 8) {
      $.ajax({
        url: "/zip-code/".concat(zipCode),
        method: 'GET',
        beforeSend: function beforeSend() {
          $('#weather-search #city, #weather-search button').attr('disabled', 'disable');
        },
        success: function success(response) {
          $('.text-danger').remove();
          if (response.city) {
            $('#city').val(response.city);
          }
        },
        error: function error(xhr) {
          $('<span id="zip-code-error" class="text-danger">CEP inválido</span>').insertAfter('.weather-zip-code');
        },
        complete: function complete() {
          $('#weather-search #city, #weather-search button').removeAttr('disabled');
        }
      });
    }
  });
  $('#weather-search').on('submit', function (event) {
    event.preventDefault();
    var city = $('#city').val();
    var formattedCity = normalizeCityName(city);
    window.location.href = "/weather/".concat(formattedCity);
  });
  function normalizeCityName(cityName) {
    return cityName.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().replace(/\s+/g, '-');
  }
});
/******/ })()
;