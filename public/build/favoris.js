(self["webpackChunk"] = self["webpackChunk"] || []).push([["favoris"],{

/***/ "./public/js/favoris.js":
/*!******************************!*\
  !*** ./public/js/favoris.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");

__webpack_require__(/*! core-js/modules/es.promise.js */ "./node_modules/core-js/modules/es.promise.js");

__webpack_require__(/*! core-js/modules/es.promise.finally.js */ "./node_modules/core-js/modules/es.promise.finally.js");

__webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");

__webpack_require__(/*! core-js/modules/es.string.replace.js */ "./node_modules/core-js/modules/es.string.replace.js");

__webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");

__webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");

function onClickBtnFavoris(event) {
  event.preventDefault();
  var url = this.href;
  var icone = this.querySelector('i');
  console.log(icone);
  axios.get(url).then(function (response) {
    // handle success
    //const favoris = response.data.favoris;
    if (icone.classList.contains('green')) {
      icone.classList.replace('green', 'light');
    } else {
      icone.classList.replace('light', 'green');
    }

    console.log(response);
  })["catch"](function (error) {
    if (error.status === 403) {
      window.alert("Vous ne pouvez pas  ajouter un microservice en favoris sans pour autant vous connecter");
    } else {
      window.alert("Une erreur s'est produite lors de la requette veuillez resayer plus tard");
    }

    console.log(error);
  })["finally"](function () {// always executed
  });
}

document.querySelectorAll('a.js-favoris').forEach(function (link) {
  link.addEventListener('click', onClickBtnFavoris);
});

/***/ }),

/***/ "./node_modules/core-js/modules/es.promise.finally.js":
/*!************************************************************!*\
  !*** ./node_modules/core-js/modules/es.promise.finally.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

"use strict";

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js/internals/export.js");
var IS_PURE = __webpack_require__(/*! ../internals/is-pure */ "./node_modules/core-js/internals/is-pure.js");
var NativePromise = __webpack_require__(/*! ../internals/native-promise-constructor */ "./node_modules/core-js/internals/native-promise-constructor.js");
var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");
var getBuiltIn = __webpack_require__(/*! ../internals/get-built-in */ "./node_modules/core-js/internals/get-built-in.js");
var isCallable = __webpack_require__(/*! ../internals/is-callable */ "./node_modules/core-js/internals/is-callable.js");
var speciesConstructor = __webpack_require__(/*! ../internals/species-constructor */ "./node_modules/core-js/internals/species-constructor.js");
var promiseResolve = __webpack_require__(/*! ../internals/promise-resolve */ "./node_modules/core-js/internals/promise-resolve.js");
var redefine = __webpack_require__(/*! ../internals/redefine */ "./node_modules/core-js/internals/redefine.js");

// Safari bug https://bugs.webkit.org/show_bug.cgi?id=200829
var NON_GENERIC = !!NativePromise && fails(function () {
  // eslint-disable-next-line unicorn/no-thenable -- required for testing
  NativePromise.prototype['finally'].call({ then: function () { /* empty */ } }, function () { /* empty */ });
});

// `Promise.prototype.finally` method
// https://tc39.es/ecma262/#sec-promise.prototype.finally
$({ target: 'Promise', proto: true, real: true, forced: NON_GENERIC }, {
  'finally': function (onFinally) {
    var C = speciesConstructor(this, getBuiltIn('Promise'));
    var isFunction = isCallable(onFinally);
    return this.then(
      isFunction ? function (x) {
        return promiseResolve(C, onFinally()).then(function () { return x; });
      } : onFinally,
      isFunction ? function (e) {
        return promiseResolve(C, onFinally()).then(function () { throw e; });
      } : onFinally
    );
  }
});

// makes sure that native promise-based APIs `Promise#finally` properly works with patched `Promise#then`
if (!IS_PURE && isCallable(NativePromise)) {
  var method = getBuiltIn('Promise').prototype['finally'];
  if (NativePromise.prototype['finally'] !== method) {
    redefine(NativePromise.prototype, 'finally', method, { unsafe: true });
  }
}


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_modules_es_array_for-each_js-node_modules_core-js_modules_es_obj-47d1b0"], () => (__webpack_exec__("./public/js/favoris.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiZmF2b3Jpcy5qcyIsIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBQUEsU0FBU0EsaUJBQVQsQ0FBMkJDLEtBQTNCLEVBQWtDO0FBQy9CQSxFQUFBQSxLQUFLLENBQUNDLGNBQU47QUFFQSxNQUFNQyxHQUFHLEdBQUcsS0FBS0MsSUFBakI7QUFDQSxNQUFNQyxLQUFLLEdBQUcsS0FBS0MsYUFBTCxDQUFtQixHQUFuQixDQUFkO0FBRUFDLEVBQUFBLE9BQU8sQ0FBQ0MsR0FBUixDQUFZSCxLQUFaO0FBRUFJLEVBQUFBLEtBQUssQ0FBQ0MsR0FBTixDQUFVUCxHQUFWLEVBQ0lRLElBREosQ0FDUyxVQUFVQyxRQUFWLEVBQW9CO0FBQ3ZCO0FBQ0E7QUFDQSxRQUFJUCxLQUFLLENBQUNRLFNBQU4sQ0FBZ0JDLFFBQWhCLENBQXlCLE9BQXpCLENBQUosRUFBdUM7QUFDcENULE1BQUFBLEtBQUssQ0FBQ1EsU0FBTixDQUFnQkUsT0FBaEIsQ0FBd0IsT0FBeEIsRUFBaUMsT0FBakM7QUFDRixLQUZELE1BR0s7QUFDRlYsTUFBQUEsS0FBSyxDQUFDUSxTQUFOLENBQWdCRSxPQUFoQixDQUF3QixPQUF4QixFQUFpQyxPQUFqQztBQUNGOztBQUVEUixJQUFBQSxPQUFPLENBQUNDLEdBQVIsQ0FBWUksUUFBWjtBQUNGLEdBWkosV0FhVSxVQUFVSSxLQUFWLEVBQWlCO0FBQ3JCLFFBQUlBLEtBQUssQ0FBQ0MsTUFBTixLQUFpQixHQUFyQixFQUEwQjtBQUN2QkMsTUFBQUEsTUFBTSxDQUFDQyxLQUFQLENBQWEsd0ZBQWI7QUFDRixLQUZELE1BRU87QUFDSkQsTUFBQUEsTUFBTSxDQUFDQyxLQUFQLENBQWEsMEVBQWI7QUFDRjs7QUFDRFosSUFBQUEsT0FBTyxDQUFDQyxHQUFSLENBQVlRLEtBQVo7QUFDRixHQXBCSixhQXFCWSxZQUFZLENBQ2xCO0FBQ0YsR0F2Qko7QUF3QkY7O0FBRURJLFFBQVEsQ0FBQ0MsZ0JBQVQsQ0FBMEIsY0FBMUIsRUFBMENDLE9BQTFDLENBQWtELFVBQVVDLElBQVYsRUFBZ0I7QUFFL0RBLEVBQUFBLElBQUksQ0FBQ0MsZ0JBQUwsQ0FBc0IsT0FBdEIsRUFBK0J4QixpQkFBL0I7QUFFRixDQUpEOzs7Ozs7Ozs7OztBQ2xDYTtBQUNiLFFBQVEsbUJBQU8sQ0FBQyx1RUFBcUI7QUFDckMsY0FBYyxtQkFBTyxDQUFDLHlFQUFzQjtBQUM1QyxvQkFBb0IsbUJBQU8sQ0FBQywrR0FBeUM7QUFDckUsWUFBWSxtQkFBTyxDQUFDLHFFQUFvQjtBQUN4QyxpQkFBaUIsbUJBQU8sQ0FBQyxtRkFBMkI7QUFDcEQsaUJBQWlCLG1CQUFPLENBQUMsaUZBQTBCO0FBQ25ELHlCQUF5QixtQkFBTyxDQUFDLGlHQUFrQztBQUNuRSxxQkFBcUIsbUJBQU8sQ0FBQyx5RkFBOEI7QUFDM0QsZUFBZSxtQkFBTyxDQUFDLDJFQUF1Qjs7QUFFOUM7QUFDQTtBQUNBO0FBQ0EsNENBQTRDLG9CQUFvQixlQUFlLGdCQUFnQixhQUFhO0FBQzVHLENBQUM7O0FBRUQ7QUFDQTtBQUNBLElBQUksaUVBQWlFO0FBQ3JFO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxpRUFBaUUsV0FBVztBQUM1RSxRQUFRO0FBQ1I7QUFDQSxpRUFBaUUsVUFBVTtBQUMzRSxRQUFRO0FBQ1I7QUFDQTtBQUNBLENBQUM7O0FBRUQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSwyREFBMkQsY0FBYztBQUN6RTtBQUNBIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcHVibGljL2pzL2Zhdm9yaXMuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMvbW9kdWxlcy9lcy5wcm9taXNlLmZpbmFsbHkuanMiXSwic291cmNlc0NvbnRlbnQiOlsiZnVuY3Rpb24gb25DbGlja0J0bkZhdm9yaXMoZXZlbnQpIHtcclxuICAgZXZlbnQucHJldmVudERlZmF1bHQoKTtcclxuXHJcbiAgIGNvbnN0IHVybCA9IHRoaXMuaHJlZjtcclxuICAgY29uc3QgaWNvbmUgPSB0aGlzLnF1ZXJ5U2VsZWN0b3IoJ2knKVxyXG5cclxuICAgY29uc29sZS5sb2coaWNvbmUpO1xyXG5cclxuICAgYXhpb3MuZ2V0KHVybClcclxuICAgICAgLnRoZW4oZnVuY3Rpb24gKHJlc3BvbnNlKSB7XHJcbiAgICAgICAgIC8vIGhhbmRsZSBzdWNjZXNzXHJcbiAgICAgICAgIC8vY29uc3QgZmF2b3JpcyA9IHJlc3BvbnNlLmRhdGEuZmF2b3JpcztcclxuICAgICAgICAgaWYgKGljb25lLmNsYXNzTGlzdC5jb250YWlucygnZ3JlZW4nKSkge1xyXG4gICAgICAgICAgICBpY29uZS5jbGFzc0xpc3QucmVwbGFjZSgnZ3JlZW4nLCAnbGlnaHQnKTtcclxuICAgICAgICAgfVxyXG4gICAgICAgICBlbHNlIHtcclxuICAgICAgICAgICAgaWNvbmUuY2xhc3NMaXN0LnJlcGxhY2UoJ2xpZ2h0JywgJ2dyZWVuJyk7XHJcbiAgICAgICAgIH1cclxuXHJcbiAgICAgICAgIGNvbnNvbGUubG9nKHJlc3BvbnNlKTtcclxuICAgICAgfSlcclxuICAgICAgLmNhdGNoKGZ1bmN0aW9uIChlcnJvcikge1xyXG4gICAgICAgICBpZiAoZXJyb3Iuc3RhdHVzID09PSA0MDMpIHtcclxuICAgICAgICAgICAgd2luZG93LmFsZXJ0KFwiVm91cyBuZSBwb3V2ZXogcGFzICBham91dGVyIHVuIG1pY3Jvc2VydmljZSBlbiBmYXZvcmlzIHNhbnMgcG91ciBhdXRhbnQgdm91cyBjb25uZWN0ZXJcIilcclxuICAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgd2luZG93LmFsZXJ0KFwiVW5lIGVycmV1ciBzJ2VzdCBwcm9kdWl0ZSBsb3JzIGRlIGxhIHJlcXVldHRlIHZldWlsbGV6IHJlc2F5ZXIgcGx1cyB0YXJkXCIpXHJcbiAgICAgICAgIH1cclxuICAgICAgICAgY29uc29sZS5sb2coZXJyb3IpO1xyXG4gICAgICB9KVxyXG4gICAgICAuZmluYWxseShmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgIC8vIGFsd2F5cyBleGVjdXRlZFxyXG4gICAgICB9KTtcclxufVxyXG5cclxuZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnYS5qcy1mYXZvcmlzJykuZm9yRWFjaChmdW5jdGlvbiAobGluaykge1xyXG5cclxuICAgbGluay5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIG9uQ2xpY2tCdG5GYXZvcmlzKVxyXG5cclxufSkiLCIndXNlIHN0cmljdCc7XG52YXIgJCA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9leHBvcnQnKTtcbnZhciBJU19QVVJFID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2lzLXB1cmUnKTtcbnZhciBOYXRpdmVQcm9taXNlID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL25hdGl2ZS1wcm9taXNlLWNvbnN0cnVjdG9yJyk7XG52YXIgZmFpbHMgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZmFpbHMnKTtcbnZhciBnZXRCdWlsdEluID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2dldC1idWlsdC1pbicpO1xudmFyIGlzQ2FsbGFibGUgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvaXMtY2FsbGFibGUnKTtcbnZhciBzcGVjaWVzQ29uc3RydWN0b3IgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvc3BlY2llcy1jb25zdHJ1Y3RvcicpO1xudmFyIHByb21pc2VSZXNvbHZlID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL3Byb21pc2UtcmVzb2x2ZScpO1xudmFyIHJlZGVmaW5lID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL3JlZGVmaW5lJyk7XG5cbi8vIFNhZmFyaSBidWcgaHR0cHM6Ly9idWdzLndlYmtpdC5vcmcvc2hvd19idWcuY2dpP2lkPTIwMDgyOVxudmFyIE5PTl9HRU5FUklDID0gISFOYXRpdmVQcm9taXNlICYmIGZhaWxzKGZ1bmN0aW9uICgpIHtcbiAgLy8gZXNsaW50LWRpc2FibGUtbmV4dC1saW5lIHVuaWNvcm4vbm8tdGhlbmFibGUgLS0gcmVxdWlyZWQgZm9yIHRlc3RpbmdcbiAgTmF0aXZlUHJvbWlzZS5wcm90b3R5cGVbJ2ZpbmFsbHknXS5jYWxsKHsgdGhlbjogZnVuY3Rpb24gKCkgeyAvKiBlbXB0eSAqLyB9IH0sIGZ1bmN0aW9uICgpIHsgLyogZW1wdHkgKi8gfSk7XG59KTtcblxuLy8gYFByb21pc2UucHJvdG90eXBlLmZpbmFsbHlgIG1ldGhvZFxuLy8gaHR0cHM6Ly90YzM5LmVzL2VjbWEyNjIvI3NlYy1wcm9taXNlLnByb3RvdHlwZS5maW5hbGx5XG4kKHsgdGFyZ2V0OiAnUHJvbWlzZScsIHByb3RvOiB0cnVlLCByZWFsOiB0cnVlLCBmb3JjZWQ6IE5PTl9HRU5FUklDIH0sIHtcbiAgJ2ZpbmFsbHknOiBmdW5jdGlvbiAob25GaW5hbGx5KSB7XG4gICAgdmFyIEMgPSBzcGVjaWVzQ29uc3RydWN0b3IodGhpcywgZ2V0QnVpbHRJbignUHJvbWlzZScpKTtcbiAgICB2YXIgaXNGdW5jdGlvbiA9IGlzQ2FsbGFibGUob25GaW5hbGx5KTtcbiAgICByZXR1cm4gdGhpcy50aGVuKFxuICAgICAgaXNGdW5jdGlvbiA/IGZ1bmN0aW9uICh4KSB7XG4gICAgICAgIHJldHVybiBwcm9taXNlUmVzb2x2ZShDLCBvbkZpbmFsbHkoKSkudGhlbihmdW5jdGlvbiAoKSB7IHJldHVybiB4OyB9KTtcbiAgICAgIH0gOiBvbkZpbmFsbHksXG4gICAgICBpc0Z1bmN0aW9uID8gZnVuY3Rpb24gKGUpIHtcbiAgICAgICAgcmV0dXJuIHByb21pc2VSZXNvbHZlKEMsIG9uRmluYWxseSgpKS50aGVuKGZ1bmN0aW9uICgpIHsgdGhyb3cgZTsgfSk7XG4gICAgICB9IDogb25GaW5hbGx5XG4gICAgKTtcbiAgfVxufSk7XG5cbi8vIG1ha2VzIHN1cmUgdGhhdCBuYXRpdmUgcHJvbWlzZS1iYXNlZCBBUElzIGBQcm9taXNlI2ZpbmFsbHlgIHByb3Blcmx5IHdvcmtzIHdpdGggcGF0Y2hlZCBgUHJvbWlzZSN0aGVuYFxuaWYgKCFJU19QVVJFICYmIGlzQ2FsbGFibGUoTmF0aXZlUHJvbWlzZSkpIHtcbiAgdmFyIG1ldGhvZCA9IGdldEJ1aWx0SW4oJ1Byb21pc2UnKS5wcm90b3R5cGVbJ2ZpbmFsbHknXTtcbiAgaWYgKE5hdGl2ZVByb21pc2UucHJvdG90eXBlWydmaW5hbGx5J10gIT09IG1ldGhvZCkge1xuICAgIHJlZGVmaW5lKE5hdGl2ZVByb21pc2UucHJvdG90eXBlLCAnZmluYWxseScsIG1ldGhvZCwgeyB1bnNhZmU6IHRydWUgfSk7XG4gIH1cbn1cbiJdLCJuYW1lcyI6WyJvbkNsaWNrQnRuRmF2b3JpcyIsImV2ZW50IiwicHJldmVudERlZmF1bHQiLCJ1cmwiLCJocmVmIiwiaWNvbmUiLCJxdWVyeVNlbGVjdG9yIiwiY29uc29sZSIsImxvZyIsImF4aW9zIiwiZ2V0IiwidGhlbiIsInJlc3BvbnNlIiwiY2xhc3NMaXN0IiwiY29udGFpbnMiLCJyZXBsYWNlIiwiZXJyb3IiLCJzdGF0dXMiLCJ3aW5kb3ciLCJhbGVydCIsImRvY3VtZW50IiwicXVlcnlTZWxlY3RvckFsbCIsImZvckVhY2giLCJsaW5rIiwiYWRkRXZlbnRMaXN0ZW5lciJdLCJzb3VyY2VSb290IjoiIn0=