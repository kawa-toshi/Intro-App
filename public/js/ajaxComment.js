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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/ajaxComment.js":
/*!*************************************!*\
  !*** ./resources/js/ajaxComment.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var comment = $(".Comment-submit__btn");
  var likePostId;
  comment.on("click", function () {
    var $this = $(this);
    var text = $("#Comment-post__textarea").val();
    likePostId = $this.data("post_id");
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: "/ajaxComment",
      dataType: "json",
      type: "POST",
      data: {
        post_id: likePostId,
        //ユーザーid.ポストid.テキストがあればいい
        text: text //コントローラーに渡すパラメーター コントローラーの$requestのなかに入る 現在のコメントのデータ

      }
    }) // 成功
    .done(function (data) {
      console.log(data.post_id);
      console.log(data.text);
      console.log(data.user_id);
      $(".Empty-message").hide();
      var html = "\n                <div class=\"Comment\">\n                    <div class=\"Profile-box\">\n                      <div class=\"Profile-box__content\">\n                        <img class=\"Profile-img\" src=\"".concat(data.profile_image, "\" alt=\"\" />\n                        <div>\n                          <p>").concat(data.user_name, "</p>\n                          <p>").concat(data.created_at, "</p>\n                        </div>\n                      </div>\n                    </div>\n                    <div class=\"Comment__text\">\n                      <p>").concat(data.text, " </p>\n                    </div>\n                    \n                    <div class=\"Btn-wrraper\">\n                      <form method=\"DELETE\" action=\"http://localhost:8888/ajaxCommentDelete\">\n                          <button type=\"submit\" id=\"commentDeleteBtn\" data-comment_id=").concat(data.comment_id, ">\n                            \u524A\u9664\n                          </button>\n                      </form>\n                    </div>\n                  </div>\n                ");
      $("#Add-comment").append(html);
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

/***/ 2:
/*!*******************************************!*\
  !*** multi ./resources/js/ajaxComment.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Applications/MAMP/htdocs/intro-app/resources/js/ajaxComment.js */"./resources/js/ajaxComment.js");


/***/ })

/******/ });