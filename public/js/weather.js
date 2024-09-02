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
/*!*********************************!*\
  !*** ./resources/js/weather.js ***!
  \*********************************/
__webpack_require__.r(__webpack_exports__);
$(document).ready(function () {
  function getLocationFromUrl() {
    var path = window.location.pathname;
    var segments = path.split('/');
    return segments[segments.length - 1];
  }
  var location = getLocationFromUrl();
  $('#save-weather').on('click', function () {
    $.ajax({
      url: "/weather-records",
      method: 'POST',
      data: {
        location: location,
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      success: function success(response) {
        $('#message').html("<div class=\"text-success\">".concat(response.message, "</div>"));
      },
      error: function error(xhr) {
        $('#message').html("<div class=\"text-danger\">".concat(xhr.responseJSON.message, "</div>"));
      }
    });
  });
});
/******/ })()
;