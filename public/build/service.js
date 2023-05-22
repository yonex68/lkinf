(self["webpackChunk"] = self["webpackChunk"] || []).push([["service"],{

/***/ "./public/js/service.js":
/*!******************************!*\
  !*** ./public/js/service.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

__webpack_require__(/*! core-js/modules/es.regexp.exec.js */ "./node_modules/core-js/modules/es.regexp.exec.js");

__webpack_require__(/*! core-js/modules/es.string.replace.js */ "./node_modules/core-js/modules/es.string.replace.js");

__webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");

__webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");

__webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");

var newItem = function newItem(e) {
  var collectionHolder = document.querySelector(e.currentTarget.dataset.collection);
  var item = document.createElement("div");
  item.classList.add("col-sm-6");
  item.innerHTML = collectionHolder.dataset.prototype.replace(/__name__/g, collectionHolder.dataset.index);
  item.querySelector(".btn-remove").addEventListener("click", function () {
    return item.remove();
  });
  collectionHolder.appendChild(item);
  collectionHolder.dataset.index++;
};

document.querySelectorAll('.btn-remove').forEach(function (btn) {
  return btn.addEventListener("click", function (e) {
    return e.currentTarget.closest(".col-sm-6").remove();
  });
});
document.querySelectorAll('.btn-new').forEach(function (btn) {
  return btn.addEventListener("click", newItem);
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_internals_advance-string-index_js-node_modules_core-js_internals-3f42c6","vendors-node_modules_core-js_modules_es_array_for-each_js-node_modules_core-js_modules_es_obj-651634"], () => (__webpack_exec__("./public/js/service.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoic2VydmljZS5qcyIsIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7Ozs7Ozs7QUFBQSxJQUFNQSxPQUFPLEdBQUcsU0FBVkEsT0FBVSxDQUFDQyxDQUFELEVBQU87QUFDcEIsTUFBTUMsZ0JBQWdCLEdBQUdDLFFBQVEsQ0FBQ0MsYUFBVCxDQUF1QkgsQ0FBQyxDQUFDSSxhQUFGLENBQWdCQyxPQUFoQixDQUF3QkMsVUFBL0MsQ0FBekI7QUFFQSxNQUFNQyxJQUFJLEdBQUdMLFFBQVEsQ0FBQ00sYUFBVCxDQUF1QixLQUF2QixDQUFiO0FBQ0FELEVBQUFBLElBQUksQ0FBQ0UsU0FBTCxDQUFlQyxHQUFmLENBQW1CLFVBQW5CO0FBQ0FILEVBQUFBLElBQUksQ0FBQ0ksU0FBTCxHQUFpQlYsZ0JBQWdCLENBQzlCSSxPQURjLENBRWRPLFNBRmMsQ0FHZEMsT0FIYyxDQUliLFdBSmEsRUFLYlosZ0JBQWdCLENBQUNJLE9BQWpCLENBQXlCUyxLQUxaLENBQWpCO0FBUUFQLEVBQUFBLElBQUksQ0FBQ0osYUFBTCxDQUFtQixhQUFuQixFQUFrQ1ksZ0JBQWxDLENBQW1ELE9BQW5ELEVBQTREO0FBQUEsV0FBTVIsSUFBSSxDQUFDUyxNQUFMLEVBQU47QUFBQSxHQUE1RDtBQUVBZixFQUFBQSxnQkFBZ0IsQ0FBQ2dCLFdBQWpCLENBQTZCVixJQUE3QjtBQUVBTixFQUFBQSxnQkFBZ0IsQ0FBQ0ksT0FBakIsQ0FBeUJTLEtBQXpCO0FBQ0QsQ0FsQkY7O0FBb0JDWixRQUFRLENBQ0xnQixnQkFESCxDQUNvQixhQURwQixFQUVHQyxPQUZILENBRVcsVUFBQUMsR0FBRztBQUFBLFNBQUlBLEdBQUcsQ0FBQ0wsZ0JBQUosQ0FBcUIsT0FBckIsRUFBOEIsVUFBQ2YsQ0FBRDtBQUFBLFdBQU9BLENBQUMsQ0FBQ0ksYUFBRixDQUFnQmlCLE9BQWhCLENBQXdCLFdBQXhCLEVBQXFDTCxNQUFyQyxFQUFQO0FBQUEsR0FBOUIsQ0FBSjtBQUFBLENBRmQ7QUFJQWQsUUFBUSxDQUNMZ0IsZ0JBREgsQ0FDb0IsVUFEcEIsRUFFR0MsT0FGSCxDQUVXLFVBQUFDLEdBQUc7QUFBQSxTQUFJQSxHQUFHLENBQUNMLGdCQUFKLENBQXFCLE9BQXJCLEVBQThCaEIsT0FBOUIsQ0FBSjtBQUFBLENBRmQiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9wdWJsaWMvanMvc2VydmljZS5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyJjb25zdCBuZXdJdGVtID0gKGUpID0+IHtcclxuICAgY29uc3QgY29sbGVjdGlvbkhvbGRlciA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoZS5jdXJyZW50VGFyZ2V0LmRhdGFzZXQuY29sbGVjdGlvbik7XHJcbiBcclxuICAgY29uc3QgaXRlbSA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJkaXZcIik7XHJcbiAgIGl0ZW0uY2xhc3NMaXN0LmFkZChcImNvbC1zbS02XCIpO1xyXG4gICBpdGVtLmlubmVySFRNTCA9IGNvbGxlY3Rpb25Ib2xkZXJcclxuICAgICAuZGF0YXNldFxyXG4gICAgIC5wcm90b3R5cGVcclxuICAgICAucmVwbGFjZShcclxuICAgICAgIC9fX25hbWVfXy9nLFxyXG4gICAgICAgY29sbGVjdGlvbkhvbGRlci5kYXRhc2V0LmluZGV4XHJcbiAgICAgKTtcclxuIFxyXG4gICBpdGVtLnF1ZXJ5U2VsZWN0b3IoXCIuYnRuLXJlbW92ZVwiKS5hZGRFdmVudExpc3RlbmVyKFwiY2xpY2tcIiwgKCkgPT4gaXRlbS5yZW1vdmUoKSk7XHJcbiBcclxuICAgY29sbGVjdGlvbkhvbGRlci5hcHBlbmRDaGlsZChpdGVtKTtcclxuIFxyXG4gICBjb2xsZWN0aW9uSG9sZGVyLmRhdGFzZXQuaW5kZXgrKztcclxuIH07XHJcbiBcclxuIGRvY3VtZW50XHJcbiAgIC5xdWVyeVNlbGVjdG9yQWxsKCcuYnRuLXJlbW92ZScpXHJcbiAgIC5mb3JFYWNoKGJ0biA9PiBidG4uYWRkRXZlbnRMaXN0ZW5lcihcImNsaWNrXCIsIChlKSA9PiBlLmN1cnJlbnRUYXJnZXQuY2xvc2VzdChcIi5jb2wtc20tNlwiKS5yZW1vdmUoKSkpO1xyXG4gXHJcbiBkb2N1bWVudFxyXG4gICAucXVlcnlTZWxlY3RvckFsbCgnLmJ0bi1uZXcnKVxyXG4gICAuZm9yRWFjaChidG4gPT4gYnRuLmFkZEV2ZW50TGlzdGVuZXIoXCJjbGlja1wiLCBuZXdJdGVtKSk7Il0sIm5hbWVzIjpbIm5ld0l0ZW0iLCJlIiwiY29sbGVjdGlvbkhvbGRlciIsImRvY3VtZW50IiwicXVlcnlTZWxlY3RvciIsImN1cnJlbnRUYXJnZXQiLCJkYXRhc2V0IiwiY29sbGVjdGlvbiIsIml0ZW0iLCJjcmVhdGVFbGVtZW50IiwiY2xhc3NMaXN0IiwiYWRkIiwiaW5uZXJIVE1MIiwicHJvdG90eXBlIiwicmVwbGFjZSIsImluZGV4IiwiYWRkRXZlbnRMaXN0ZW5lciIsInJlbW92ZSIsImFwcGVuZENoaWxkIiwicXVlcnlTZWxlY3RvckFsbCIsImZvckVhY2giLCJidG4iLCJjbG9zZXN0Il0sInNvdXJjZVJvb3QiOiIifQ==