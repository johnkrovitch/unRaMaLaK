/**
 * Map class
 */
$.Class('Unramalak.Map', {}, {
  id: 0,
  cells: [],
  cellsData: [],
  cellPadding: 0,
  height: 0,
  hitCells: [],
  menu: null,
  // contains data from menu (what kind of button has been clicked, what is its value...)
  menuData: [],
  menuContainer: '',
  name: 'New Map',
  numberOfSides: 0,
  radius: 0,
  startingPoint: null,
  width: 0,

  /**
   * Initialize map parameters
   * @param context
   */
  init: function (context) {

    if (context.preventBubbling) {
      this.preventBubbling();
    }
    if ($.isNotNull(context.data)) {
      this.id = context.data.id;

      if ($.isArray(context.data.cells) && $.isNotNull(context.data.cells)) {
        this.cellsData = context.data.cells;
      }
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

  load: function (data) {
    // map must build paper.js object's before binding events on them
    this.draw();
    this.bind();
    this.bindMenu();
  },

  bind: function () {
    var _super = this;

    $.each(this.cells, function (index, cell) {
      // onMouseDown
      cell.attach('mousedown', function (paperEvent) {
        // get current cell state before deselecting all cells
        var selected = this.selected;
        // click on cell: unselect others cells and add clicked cell to selected unless it's already clicked.
        // If <Ctrl> was press, we do not deselect cells
        if (!paperEvent.event.ctrlKey) {
          _super.unselect();
        }
        // if cell was not selected, we select it
        if (!selected) {
          _super.hitCells.push(this);
        }
      });
      // onMouseUp
      cell.attach('mouseup', function (paperEvent) {
        _super.update();
      });
    });
    // onclick anywhere but on menu and map, unselect user choice
    $(document).on('click', function () {
      _super.menu.unselect();
      _super.unselect();
    });
  },

  bindMenu: function () {
    var _super = this;
    // create menu
    this.menu = new Unramalak.Menu(this.menuContainer, 'mainMenu');
    this.menu.build();
    this.menu.container.bind('mainMenu.click', function (e, type, value) {
      // keep editor's changes
      _super.menuData.push({'type': type, 'value': value});
    });
    this.menu.container.bind('mainMenu.unselect', function () {
      // keep editor's changes
      _super.menuData = [];
    });
    this.menu.container.bind('mainMenu.save', function () {
      console.log('save');
      _super.save();
    });
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
        hexagon.fillColor = '#e9e9ff';
        hexagon.strokeColor = '#a2a2f2';
        // x-radius of shape : distance between center and one of his point.
        // distance between this shape and the next is equals to a diameter (plus an optional padding)
        xRadius = hexagonCenter.x - hexagon.segments[0].point.x;
        hexagonCenterX += xRadius * 2 + this.cellPadding;
        // push to map cells array
        this.cells.push(new Unramalak.Map.Cell(hexagon, {x: i, y: j, background: hexagon.fillColor}));
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
      cell.selected = true;

      // if user clicked on editor, we handle that
      if (_super.menuData.length > 0) {
        cell.fillColor = _super.menuData[0].value;
      }
    });
    // then reset hitCells
    this.hitCells = [];
  },

  save: function () {
    var jsonData;
    var mapId = this.id;
    var cellsValues = [];

    // save stuff here
    $(this.cells).each(function (index, cell) {
      cellsValues.push(cell.toString());
      console.log(cell.toString());
    });
    jsonData = JSON.stringify(cellsValues);
    $.ajax({
      type: 'POST',
      url: 'save',
      data: 'id=' + mapId + '&data=' + jsonData
    });
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

  attach: function (event, callback) {
    this.shape.attach(event, callback);
  },

  toString: function () {
    var data = {
      x: this.data.x,
      y: this.data.y
    };
    if (this.data.background) {
      data.background = {red: this.data.background.red, blue: this.data.background.blue, green: this.data.background.green, alpha: this.data.background.alpha}
    }
    return data;
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