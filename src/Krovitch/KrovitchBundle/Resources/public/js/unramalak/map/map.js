var defaultBackgroundColor = '#e9e9ff';
var defaultStrokeColor = '#a2a2f2';

/**
 * Map class
 */
$.Class('Unramalak.Map', {}, {
  cells: null,
  cellsData: [],
  cellPadding: 0,
  height: 0,
  hitCells: [],
  keyboardControl: null,
  menu: null,
  name: 'New Map',
  numberOfSides: 0,
  onNotify: null,
  radius: 0,
  renderer: null,
  startingPoint: null,
  units: [],
  width: 0,

  /**
   * Initialize map parameters, gathering data from context
   * @param context Execution context. Should contains all data required by map (like canvasId, name, cells data...)
   * @param renderer
   */
  init: function (context, renderer) {

    if (context.preventBubbling) {
      this.preventBubbling();
    }
    if ($.isNotNull(context.data.cells)) {
      this.load(context.data)
    }
    this.cellPadding = context.cellPadding;
    this.height = context.data.height;
    this.name = context.data.name;
    this.numberOfSides = context.numberOfSides;
    this.radius = context.radius;
    this.startingPoint = context.startingPoint;
    this.width = context.data.width;
    // create menu
    this.menu = new Unramalak.Menu(context.menuContainer, 'mainMenu');
    //  init cell collections
    this.cells = new Unramalak.CellCollection();
    this.hitCells = [];
    this.renderer = renderer;
  },

  load: function (data) {
    // load cells data
    if (data && data.cells) {
      this.cellsData = JSON.parse(data.cells);
    }
  },

  bind: function (onNotify) {
    var _super = this;

    this.cells.each(this, function (cell) {
      // onMouseDown
      cell.bind('mousedown', function (paperEvent) {
        // get current cell state before deselecting all cells
        var selected = cell.shape.selected;
        // click on cell: unselect others cells and add clicked cell to selected unless it's already clicked.
        // If <Ctrl> was press, we do not deselect cells
        if (!paperEvent.event.ctrlKey) {
          cell.shape.selected = false;
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
    // bind menu events
    this.menu.bind(this.save, this);
    this.onNotify = onNotify;
    // bind controls
    this.keyboardControl = new Unramalak.Keyboard();
    this.keyboardControl.bind(this, this.move, this.units[0].shape);
  },

  /**
   * Creates cells with theirs data
   */
  build: function () {
    // build cells
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
        // TODO ugly ! should be rewrite
        if (this.cellsData.length) {
          //console.log('data', JSON.parse(this.cellsData[i * this.width + j]));
          cellData = JSON.parse(this.cellsData[i * this.width + j]);
          //cellData.background = new paper.RgbColor(cellData.background.red, cellData.background.green, cellData.background.blue, cellData.background.alpha);
        }
        this.cells.add(new Unramalak.Cell(hexagon, cellData));
      }
      odd = !odd;
      // y-radius
      yRadius = hexagonCenter.y - hexagon.segments[0].point.y;
      hexagonCenterY += yRadius * 3 + this.cellPadding;
    }
    // build units
    var firstPoint = this.cells.getFirst().getHighPoint();
    var unitOrigin = new paper.Point(firstPoint.x, firstPoint.y + this.radius);
    var unit = new Unramalak.Unit(unitOrigin);
    unit.build();
    this.units.push(unit);

    var originCell = this.cells.getFirst();
    originCell.addUnit(unit);
  },

  /**
   * Move a target in a direction
   * @param target paper.js object
   * @param direction vector
   */
  move: function (target, direction) {
    this.renderer.animate(target, direction);
  },

  render: function () {
    this.renderer = new Unramalak.Renderer();
    // draw cells
    this.cells.each(this, function (cell) {
      cell.render();
    });
    // draw units
    this.units.forEach(function (unit) {
      unit.render();
    });
  },

  /**
   * Unselect cells
   */
  unselect: function () {
//    $.each(this.cells, function (index, cell) {
//      cell.shape.selected = false;
//    });
  },

  update: function () {
    var _super = this;
    // if cells have been clicked or drag
    $.each(_super.hitCells, function (index, cell) {
      // if a item menu button was pressed
      if (_super.menu.hasData('land')) {
        cell.setBackground(_super.menu.getData('land'));
        cell.render();
      }
      if (cell.hasUnit()) {
        cell.units[0].shape.selected = true;
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

    // save stuff here
    this.cells.each(this, function (cell) {
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
    $(document).on('keyup', function (e) {
      // TODO prevent browser from scrolling
      /*console.log('keyup');
      e.stopPropagation();
      e.preventDefault();
      e.stopImmediatePropagation();
      return false;*/
    });
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