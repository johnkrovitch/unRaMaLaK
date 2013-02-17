/**
 * Unramalak.Cell
 */
$.Class('Unramalak.Map.Cell', {}, {
  data: {
    x: null,
    y: null,
    background: null
  },
  shape: null,

  init: function (shape, data) {
    this.data = data;
    this.shape = shape;
  },

  bind: function (event, callback) {
    this.shape.attach(event, callback);
  },

  setBackground: function (background) {
    if ($.isNull(background)) {
      background = defaultBackgroundColor;
    }
    this.shape.fillColor = background;
  },

  toString: function () {
    var data = {
      x: this.data.x,
      y: this.data.y,
      background: {
        red: this.shape.fillColor.red,
        green: this.shape.fillColor.green,
        blue: this.shape.fillColor.blue,
        alpha: this.shape.fillColor.alpha
      }
    };
    return JSON.stringify(data);
  }
});

$.Class('Unramalak.Map.CellCollection', {}, {
  cells: []
});