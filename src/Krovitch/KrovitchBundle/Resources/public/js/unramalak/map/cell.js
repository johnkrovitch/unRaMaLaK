/**
 * Unramalak.Cell
 */
Unramalak.Container('Unramalak.Cell', {}, {
  shape: null,
  data: {
    x: null,
    y: null,
    background: null
  },

  init: function (shape, data) {
    this.data = data;
    this.shape = shape;
  },

  bind: function (event, callback) {
    this.shape.attach(event, callback);
  },

  /**
   * Return the point on the top of the shape
   * @returns Point
   */
  getHighPoint: function () {
    return this.shape.segments[1].point;
  },

  render: function () {
    this.shape.fillColor = this.data.background;
    this.shape.strokeColor = defaultStrokeColor;
  },

  setBackground: function (background) {
    if ($.isNull(background)) {
      background = defaultBackgroundColor;
    }
    this.data.background = background;
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
      for (column in this.cells[row]) {
        callback.call(map || this, this.cells[row][column]);
      }
    }
  },

  getFirst: function () {
    return this.cells[0][0];
  },

  reset: function () {
    this.group.background = defaultBackgroundColor;
  },

  render: function () {
    // draw cells
    this.each(this, function (cell) {
      cell.render();
    });
  }
});