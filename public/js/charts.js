/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/charts.js ***!
  \********************************/
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

window.chart = {
  data: [],
  selector_svg: "#svg1",
  selector_chart_box: "#chart_box",
  offset_bottom: 20,
  max_height: 300,
  max_data: 0,
  w: 7,
  ids: [],
  month: 1,
  year: 2022,
  set: function set(data) {
    var _this = this;

    _this.data = data;
    _this.max_data = Math.max.apply(Math, _toConsumableArray(data));
  },
  getMonth: function getMonth(month) {
    var arr_months = ['Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];
    return arr_months[month];
  },
  drawItem: function drawItem(n, val) {
    var _this = this;

    var height_step = (this.max_height - this.max_height / 5) / this.max_data;
    var h, x1, y1;

    if (!val) {
      h = 1;
      y1 = this.max_height - this.offset_bottom;
    } else {
      h = val * height_step + height_step;
      y1 = this.max_height - h - this.offset_bottom;
    }

    var x1 = this.w + n * this.w + (n - 1) * this.w;
    var rect = d3.select(this.selector_svg).append("rect").attr("x", x1).attr("y", y1).attr("width", this.w).attr("height", h).attr("style", "fill:#0d6efd").attr("param-title", "\u0417\u0430\u044F\u0432\u043A\u0438 \u043E\u0442 ".concat(n, " ").concat(this.getMonth(this.month), " ").concat(this.year)).attr("param-value", "\u0412\u0441\u0435\u0433\u043E \u0437\u0430\u044F\u0432\u043E\u043A ".concat(val)).attr("class", "chart-rect").on("mouseover", function (d) {
      var title = $(this).attr("param-title");
      var value = $(this).attr("param-value");

      _this.drawBox(d.clientX, d.clientY, title, value);
    }).on("mouseout", function (d) {
      _this.removeBox();
    });
    var txt = d3.select(this.selector_svg).append("text").attr("x", x1 + this.w / 2).attr("y", this.max_height - 15).attr("fill", "#fff").attr("font-size", 7).attr("style", "writing-mode: tb;").text(n);
  },
  draw: function draw() {
    var _this = this;

    d3.select(this.selector_svg).selectAll("*").remove();
    this.data.forEach(function (item, index) {
      _this.drawItem(index + 1, item);
    });
  },
  removeBox: function removeBox() {
    $(this.selector_chart_box).css("display", "none");
  },
  drawBox: function drawBox(x, y, title, value) {
    $(this.selector_chart_box).css("left", x);
    $(this.selector_chart_box).css("top", y);
    $(this.selector_chart_box).css("display", "block");
    $(this.selector_chart_box).find(".title").html(title);
    $(this.selector_chart_box).find(".body").html(value);
  }
};
/******/ })()
;