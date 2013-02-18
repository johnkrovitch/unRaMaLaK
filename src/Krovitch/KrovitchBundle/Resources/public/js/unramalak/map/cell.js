/**
 * Unramalak.Cell
 */
$.Class('Unramalak.Cell', {}, {
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

  render: function (background) {
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

$.Class('Unramalak.CellCollection', {}, {
  cells: [],
  group: null,

  init: function () {
    this.group = new paper.Group();
  },

  add: function (cell) {
    var x = cell.data.x;
    var y = cell.data.y;

    if ($.isNull(this.cells[x])) {
      this.cells[x] = [];
    }
    this.cells[x][y] = cell;
    // add in paper.js group for mass manipulations
    this.group.addChild(cell.shape);
  },

  each: function (map, callback) {
    var row, column;

    for (row in this.cells) {
      for (column in row) {
        console.log('bind', this.cells, row, column, this.cells[row][column]);
        callback.call(map||this, this.cells[row][column]);
      }
    }
  },

  reset: function () {
    this.group.background = defaultBackgroundColor;
  }
});