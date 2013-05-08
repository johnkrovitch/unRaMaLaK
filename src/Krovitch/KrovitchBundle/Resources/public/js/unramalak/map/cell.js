/**
 * Unramalak.BaseCell
 */
Unramalak.Container('Unramalak.BaseCell', {}, {
  land: null,
  shape: null,
  data: {
    x: null,
    y: null
  },

  init: function (shape, data) {
    this.data = data;
    this.shape = shape;
    this.land = new Unramalak.Land();

    if (!this.data.background) {
      this.data.background = defaultBackgroundColor;
    }
    if (this.data.type) {
      this.land.type = this.data.type;
    }
  },

  bind: function (event, callback) {
    this.shape.attach(event, callback);
  },

  /**
   * Return a json string of the cell
   * @returns object
   */
  toJson: function () {
    return {
      x: this.data.x,
      y: this.data.y,
      type: this.land.type
    };
  }
});

/**
 * Unramalak.Cell
 */
Unramalak.BaseCell('Unramalak.Cell', {}, {
  /**
   * Return the point on the top of the shape
   * @returns Point
   */
  getHighPoint: function () {
    return this.shape.segments[1].point;
  },

  getCenter: function () {

  },

  render: function () {
    var render = this.land.render();

    if (render == '') {

    }
    console.log('render', this.shape.position);
    this.shape.fillColor = render;
    this.shape.strokeColor = defaultStrokeColor;
  }
});


$.Class('Unramalak.Land', {}, {
  type: 'default',
  image: null,

  render: function () {
    var color = defaultBackgroundColor;

    if (this.type == 'sand') {
      color = 'yellow';
    }
    else if (this.type == 'water') {
      color = 'blue';
    }
    return color;
  }
});

/**
 * Unramalak.CellCollection
 */
$.Class('Unramalak.CellCollection', {}, {
  cells: [],
  group: null,

  /**
   * Initialize a new collection
   */
  init: function () {
    this.group = new paper.Group();
  },

  /**
   * Add a cell into collection
   * @param cell
   */
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

  /**
   * Loop through collection items
   * @param map
   * @param callback
   */
  each: function (map, callback) {
    var row, column;

    for (row in this.cells) {
      for (column in this.cells[row]) {
        callback.call(map || this, this.cells[row][column]);
      }
    }
  },

  /**
   * Return first cell of the collection
   * @returns Unramalak.Cell
   */
  getFirst: function () {
    return (this.cells.length > 0) ? this.cells[0][0] : null;
  },

  getBounds: function () {
    return this.group.getHandleBounds();
  },

  /**
   * Reset cells background to default color
   */
  reset: function () {
    this.group.background = defaultBackgroundColor;
  },

  translate: function (direction) {
    this.group.translate(direction);
  },

  /**
   * Render each element of the collection
   */
  render: function () {
    // draw cells
    this.each(this, function (cell) {
      cell.render();
    });
  }
});