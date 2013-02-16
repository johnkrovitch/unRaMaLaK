var defaultBackgroundColor = '#e9e9ff';

/**
 * Map class
 */
$.Class('Unramalak.Map', {}, {
  // TODO refactor Map members (too much)
  id: 0,
  cells: [],
  cellsData: [],
  cellPadding: 0,
  container: '',
  data: null,
  height: 0,
  hitCells: [],
  menu: null,
  // contains data from menu (what kind of button has been clicked, what is its value...)
  menuData: [],
  menuContainer: '',
  name: 'New Map',
  numberOfSides: 0,
  onNotify: null,
  radius: 0,
  startingPoint: null,
  width: 0,

  /**
   * Initialize map parameters, gathering data from context
   * @param context Execution context. Should contains all data required by map (like canvasId, name, cells data...)
   */
  init: function (context) {

    if (context.preventBubbling) {
      this.preventBubbling();
    }
    if ($.isNotNull(context.data.cells)) {
      this.data = context.data;
    }
    this.cellPadding = context.cellPadding;
    this.height = context.data.height;
    this.menuContainer = context.menuContainer;
    this.name = context.data.name;
    this.numberOfSides = context.numberOfSides;
    this.radius = context.radius;
    this.startingPoint = context.startingPoint;
    this.width = context.data.width;
  },

  load: function () {
    var _super = this;
    // load cells data
    console.log('load cells', this.data);

    if (this.data) {
      this.cellsData = JSON.parse(this.data.cells);
    }
    // map must build paper.js object's before binding events on them
    this.draw();
    /*$.each(this.data, function (index, value) {
     console.log('load values', value);
     _super.cellsData[value.x] = value;
     });*/
  },

  bind: function (onNotify) {
    var _super = this;

    $.each(this.cells, function (index, cell) {
      // onMouseDown
      cell.bind('mousedown', function (paperEvent) {
        // get current cell state before deselecting all cells
        var selected = this.selected;
        // click on cell: unselect others cells and add clicked cell to selected unless it's already clicked.
        // If <Ctrl> was press, we do not deselect cells
        if (!paperEvent.event.ctrlKey) {
          _super.unselect();
        }
        // if cell was not selected, we select it
        if (!selected) {
          _super.hitCells.push(cell);
        }
      });
      // onMouseUp
      cell.bind('mouseup', function (paperEvent) {
        _super.update();
      });
    });
    // onclick anywhere but on menu and map, unselect user choice
    $(document).on('click', function () {
      _super.menu.unselect();
      _super.unselect();
    });
    // create menu
    this.menu = new Unramalak.Menu(this.menuContainer, 'mainMenu');
    this.menu.bind(this.save, this);
    this.onNotify = onNotify;
  },

  onclick: function (e, type, value) {
    this.menuData.push({'type': type, 'value': value});
  },

  /**
   * Render the map with options in context
   */
  draw: function () {
    var odd = false;
    var hexagonCenterX = this.startingPoint.x;
    var hexagonCenterY = this.startingPoint.y;
    var xRadius = 0;
    var yRadius = 0;

    for (var i = 0; i < this.width; i++) {
      var extraCells = 0;
      hexagonCenterX = this.startingPoint.x;

      if (odd) {
        // case of hexagons : each row is staggered with previous
        // += : les lignes pairs (0,2,4...) ne commencent pas au bord de la map
        // -= : les lignes impairs (1,3...) ne commencent pas au bord de la map
        hexagonCenterX -= xRadius;
        extraCells = 1;
      }
      for (var j = 0; j < (this.height + extraCells); j++) {
        var hexagonCenter = new paper.Point(hexagonCenterX, hexagonCenterY);
        var hexagon = new paper.Path.RegularPolygon(hexagonCenter, this.numberOfSides, this.radius);
        hexagon.strokeColor = '#a2a2f2';
        // x-radius of shape : distance between center and one of his point.
        // distance between this shape and the next is equals to a diameter (plus an optional padding)
        xRadius = hexagonCenter.x - hexagon.segments[0].point.x;
        hexagonCenterX += xRadius * 2 + this.cellPadding;

        // create cell object to ease further manipulations
        var cellData = {
          x: i,
          y: j,
          background: defaultBackgroundColor
        };
        if (this.cellsData.length) {
          cellData = JSON.parse(this.cellsData[i * this.width + j]);
          cellData.background = new paper.RgbColor(cellData.background.red, cellData.background.green, cellData.background.blue, cellData.background.alpha);
        }
        // if bg data were loaded, we bind
        hexagon.fillColor = cellData.background;

        this.cells.push(new Unramalak.Map.Cell(hexagon, cellData));
      }
      odd = !odd;
      // y-radius
      yRadius = hexagonCenter.y - hexagon.segments[0].point.y;
      hexagonCenterY += yRadius * 3 + this.cellPadding;
    }
  },

  /**
   * Unselect cells
   */
  unselect: function () {
    $.each(this.cells, function (index, cell) {
      cell.shape.selected = false;
    });
  },

  update: function () {
    var _super = this;

    // if cells have been clicked or drag
    $.each(_super.hitCells, function (index, cell) {
      // if user clicked on editor, we handle that
      if (_super.menuData.length > 0) {
        cell.setBackground(_super.menuData[0].value);
      }
    });
    // then reset hitCells
    this.hitCells = [];
  },

  save: function () {
    var jsonData;
    var mapId = this.id;
    var cellsValues = [];
    var _super = this;

    console.log(this);

    // save stuff here
    $(this.cells).each(function (index, cell) {
      cellsValues.push(cell.toString());
    });
    jsonData = JSON.stringify(cellsValues);
    // call ajax url
    $.ajax({
      type: 'POST',
      url: 'save',
      data: 'id=' + mapId + '&data=' + jsonData,
      success: function () {
        _super.notify('Map successfully saved !', 'success');
      },
      error: function () {
        _super.notify('An error has occurred during map save', 'error')
      }
    });
  },

  notify: function (message, type) {
    this.onNotify(message, type);
  },

  /**
   * Prevents canvas events bubbling
   */
  preventBubbling: function () {
    $('canvas').on('click', function (e) {
      e.stopPropagation();
      e.preventDefault();
    });
  }
});

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
      background = defaultBackgroundColor
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

$.Class('Unramalak.Map.Context', {}, {
  data: null,
  cellPadding: 0,
  mapContainer: '',
  menuContainer: '',
  numberOfSides: 0,
  preventBubbling: true, // not customizable now
  radius: 0,
  startingPoint: null,

  init: function (mapOptions) {
    this.cellPadding = mapOptions.cellPadding;
    this.data = mapOptions.data;
    this.mapContainer = mapOptions.mapContainer;
    this.menuContainer = mapOptions.menuContainer;
    this.numberOfSides = mapOptions.numberOfSides;
    this.radius = mapOptions.radius;
    this.startingPoint = mapOptions.startingPoint;
  }
});