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
      //console.log('new array ');
      this.cells[x] = [];
    }
    //console.log('add cell :', x, y, this.cells);

    this.cells[x][y] = cell;
    // add in paper.js group for mass manipulations
    this.group.addChild(cell.shape);
  },

  each: function (map, callback) {
    var row, column;

    for (row in this.cells) {
      for (column in this.cells[row]) {
        //console.log('row', this.cells[row][column].data);
        callback.call(map||this, this.cells[row][column]);
      }
    }
  },

  reset: function () {
    this.group.background = defaultBackgroundColor;
  }
});