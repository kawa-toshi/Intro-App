/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/ajaxCommentDelete.js":
/*!*******************************************!*\
  !*** ./resources/js/ajaxCommentDelete.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var commentId;
  $(document).on("click", "#commentDeleteBtn", function () {
    var $this = $(this);
    commentId = $this.attr("data-comment_id");
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: "/ajaxCommentDelete",
      dataType: "json",
      type: "POST",
      data: {
        comment_id: commentId,
        //削除したいコメントのID
        _method: "DELETE"
      }
    }) // 成功
    .done(function (data) {
      // コメントがありませんを作成
      var html = "\n                <div class=\"Empty-message\">\n                  <p>\u30B3\u30E1\u30F3\u30C8\u306F\u307E\u3060\u3042\u308A\u307E\u305B\u3093</p>\n                </div>\n              "; // コメントがありませんのメッセージがあるかどうか判定
      // あらかじめコメントが入っている場合

      if ($(".Empty-message").length == 0) {
        // さらにあらかじめコメントが一つの場合と複数の場合で判定
        if ($(".Comment").length == 1) {
          $this.parents(".Comment").remove();
          $("#Add-empty").append(html);
        } else {
          $this.parents(".Comment").remove();
        }
      } else {
        // あらかじめコメントが入ってない場合
        // さらにコメントが追加された後の判定
        if ($(".Comment").length == 1) {
          $(".Empty-message").show();
          $this.parents(".Comment").remove();
        } else {
          $this.parents(".Comment").remove();
        }
      }
    }) // 失敗
    .fail(function (data, xhr, err) {
      // エラー内容を記述。
      console.log("エラー");
      console.log(err);
      console.log(xhr);
    });
    return false;
  });
});

/***/ }),

/***/ 3:
/*!*************************************************!*\
  !*** multi ./resources/js/ajaxCommentDelete.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Applications/MAMP/htdocs/intro-app/resources/js/ajaxCommentDelete.js */"./resources/js/ajaxCommentDelete.js");


/***/ })

/******/ });