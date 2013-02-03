/**
 * Map class
 */
$.Class('Unramalak.Map', {}, {
  cells: [],
  context: null,
  hitCells: [],
  menu: null,
  menuData: [],

  /**
   * Initialize map parameters
   * @param context
   */
  init: function (context) {
    this.context = context;
  },

  bindMenu: function () {
    var _super = this;
    // create menu
    this.menu = new Unramalak.Menu(this.context.menuContainer, 'mainMenu');
    this.menu.build();
    this.menu.container.bind('mainMenu.click', function (e, type, value) {
      // keep editor's changes
      _super.menuData.push({'type': type, 'value': value});
    });
    this.menu.container.bind('mainMenu.unselect', function (e) {
      // keep editor's changes
      _super.menuData = [];
    });
    this.menu.container.bind('mainMenu.save', function (e) {
      console.log('save');
    });
  },

  /**
   * Render the map with options in context
   */
  draw: function () {
    var odd = false;
    var mapSize = {x: 10, y: 10};
    var hexagonCenterX = this.context.startingPoint.x;
    var hexagonCenterY = this.context.startingPoint.y;
    var xRadius = 0;
    var yRadius = 0;

    for (var i = 0; i < mapSize.x; i++) {
      var extraCells = 0;
      hexagonCenterX = this.context.startingPoint.x;

      if (odd) {
        // case of hexagons : each row is staggered with previous
        // += : les lignes pairs (0,2,4...) ne commencent pas au bord de la map
        // -= : les lignes impairs (1,3...) ne commencent pas au bord de la map
        hexagonCenterX -= xRadius;
        extraCells = 1;
      }
      for (var j = 0; j < (mapSize.y + extraCells); j++) {
        var hexagonCenter = new paper.Point(hexagonCenterX, hexagonCenterY);
        var hexagon = new paper.Path.RegularPolygon(hexagonCenter, this.context.numberOfSides, this.context.radius);
        hexagon.fillColor = '#e9e9ff';
        hexagon.strokeColor = '#a2a2f2';

        // x-radius of shape : distance between center and one of his point.
        // distance between this shape and the next is equals to a diameter (plus an optional padding)
        xRadius = hexagonCenter.x - hexagon.segments[0].point.x;
        hexagonCenterX += xRadius * 2 + this.context.cellPadding;

        this.cells.push(new Unramalak.Cell(hexagon, data));
      }
      odd = !odd;
      // y-radius
      yRadius = hexagonCenter.y - hexagon.segments[0].point.y;
      hexagonCenterY += yRadius * 3 + this.context.cellPadding;
    }
  },

  bind: function () {
    var _super = this;
    // bind menu events
    this.bindMenu();

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
    });
  },

  /**
   * Unselect cells
   */
  unselect: function () {
    $.each(this.cells, function (index, cell) {
      cell.selected = false;
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
/*****************************/

$.Class('Unramalak.Cell', {}, {
  shape: null,
  data: {},

  init: function (shape, data) {
    this.shape = shape;
    this.data = data;
  }
});

$.Class('Unramalak.MapContext', {}, {
  // map paper canvas options
  startingPoint: null,
  numberOfSides: 0,
  radius: 0,
  cellPadding: 0,
  menuContainer: null,
  cells: [],

  init: function (mapOptions) {
    console.log('mapContext.init', mapOptions);

    this.startingPoint = mapOptions.startingPoint;
    this.numberOfSides = mapOptions.numberOfSides;
    this.radius = mapOptions.radius;
    this.cellPadding = mapOptions.cellPadding;
    this.menuContainer = mapOptions.menuContainer;
    this.cells = mapOptions.cells;
  }
});