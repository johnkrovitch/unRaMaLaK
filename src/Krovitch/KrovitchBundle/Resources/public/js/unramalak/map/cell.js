/**
 * Unramalak.BaseCell
 */
Unramalak.Container('Unramalak.BaseCell', {}, {
  land: null,
  shape: null,
  raster: null,
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

  getPosition: function () {
    return this.shape.position;
  },

  /**
   * Render current cell. If cell land has an image render type,
   * it use ImageLoader to load paper raster
   */
  render: function () {
    var render = this.land.render();
    // default render
    if (render.type == 'default') {
      this.shape.fillColor = render.value;
    }
    // texture render
    else if (render.type == 'image') {
      var raster = Unramalak.ImageLoader.createRaster(render.value);
      if (!this.raster) {
        this.raster = raster;
        //this.raster = raster.clone();
        console.log('raster ', raster);
      }
      if (this.raster && this.raster != raster) {
        //this.raster.remove();
        //this.raster = raster;
      }
      console.log('render cell', this);
      this.raster.setPosition(this.getPosition());
    }
    this.shape.strokeColor = defaultStrokeColor;
  }
});

/**
 * Unramalak.Land
 */
$.Class('Unramalak.Land', {}, {
  type: 'default',
  image: null,

  render: function () {
    var render = {
      type: 'default',
      value: defaultBackgroundColor
    };
    // TODO put textures here
    if (this.type == 'sand') {
      render.value = 'yellow';
    }
    else if (this.type == 'water') {
      render.value = 'blue';
    }
    else if (this.type == 'plains') {
      render.type = 'image';
      render.value = 'land_plains';
    }
    return render;
  }
});

/**
 * Unramalak.CellCollection
 */
$.Class('Unramalak.CellCollection', {}, {
  cells: [],
  group: null,
  hitCells: [],

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
    //this.group.addChild(cell.raster);
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

  hitCell: function (cell) {
    this.hitCells.push(cell);
  },

  /**
   * Reset cells background to default color
   */
  reset: function () {
    this.group.background = defaultBackgroundColor;
  },

  translate: function (direction) {
    //console.log('group', this.group.children[0].position);
    this.group.translate(direction);
    //console.log('group', this.group.children[0].position);
  },

  update: function (data) {
    var cellIndex, cell;

    for (cellIndex in this.cells) {
      cell = this.hitCells[cellIndex];

      if (data['land']) {
        cell.land.type = data['land'];
        cell.render();
        console.log('parent ?', this.group.isParent(cell.raster));
        console.log('ancestor ?', this.group.isAncestor(cell.raster));
        this.group.addChild(cell.raster);
      }
    }
  },

  /**
   * Render each element of the collection
   */
  render: function () {

    var rasterGroup = [];
    this.each(this, function (cell) {
      cell.render();



      if ($.isNotNull(cell.raster)) {
        this.group.addChild(cell.raster);

      }
    });
    // adding raster to main group
    //this.group.addChild(rasterGroup);
    // draw cells
  }
});