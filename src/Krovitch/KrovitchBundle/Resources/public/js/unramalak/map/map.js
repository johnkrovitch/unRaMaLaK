var defaultBackgroundColor = '#e9e9ff';
var defaultStrokeColor = '#a2a2f2';


/**
 * Map class
 */
$.Class('Unramalak.Map', {}, {
  cells: null,
  cellsData: [],
  cellPadding: 0,
  // errors encountered during some process
  errors : [],
  hitCells: [],
  keyboardControl: null,
  menu: null,
  numberOfSides: 0,
  onNotify: null,
  profile: {},
  radius: 0,
  renderer: null,
  startingPoint: null,
  units: [],

  /**
   * Initialize map parameters, gathering data from context
   * @param context Execution context. Should contains all data required by map (like canvasId, name, cells data...)
   */
  init: function (context) {
    if (context.preventBubbling) {
      this.preventBubbling();length
    }
    if ($.isNotNull(context.data)) {
      this.load(context.data);
    }
    this.cellPadding = context.cellPadding;
    this.numberOfSides = context.numberOfSides;
    this.radius = context.radius;
    this.startingPoint = context.startingPoint;
    // create menu
    this.menu = new Unramalak.Menu(context.menuContainer, 'mainMenu');
    //  init cell collections
    this.cells = new Unramalak.CellCollection();
    this.hitCells = [];
    this.renderer =  new Unramalak.Renderer();
  },

  /**
   * Load data from context. Those data will be used during map building
   * @param data
   */
  load: function (data) {
    // load cells
    if (data.cells) {
      var cellIndex;

      for (cellIndex in data.cells) {
        var cell = data.cells[cellIndex];

        if ($.isNull(this.cellsData[cell.x])) {
          this.cellsData[cell.x] = [];
        }
        if ($.isNull(this.cellsData[cell.x][cell.y])) {
          this.cellsData[cell.x][cell.y] = [];
        }
        this.cellsData[cell.x][cell.y] = cell;
      }
    }
    // load map profile
    if (data.profile) {
      this.profile = data.profile;
    }
    // TODO manage events loading
  },

  bind: function (onNotify) {
    var _super = this;

    this.cells.each(this, function (cell) {
      // onMouseDown
      cell.shape.attach('mousedown', function (paperEvent) {
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
    //this.keyboardControl.bind(this, this.move, this.units[0].shape);
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

    for (var i = 0; i < this.profile.width; i++) {
      hexagonCenterX = this.startingPoint.x;

      if (odd) {
        // case of hexagons : each row is staggered with previous
        // += : odd row started at the edge of the map
        // -= : even row started at the edge of the map
        hexagonCenterX -= xRadius;
      }
      for (var j = 0; j < (this.profile.height); j++) {
        var hexagonCenter = new paper.Point(hexagonCenterX, hexagonCenterY);
        var hexagon = new paper.Path.RegularPolygon(hexagonCenter, this.numberOfSides, this.radius);
        // x-radius of shape : distance between center and one of his point.
        // distance between this shape and the next is equals to a diameter (plus an optional padding)
        xRadius = hexagonCenter.x - hexagon.segments[0].point.x;
        hexagonCenterX += xRadius * 2 + this.cellPadding;

        // default cells
        var cellData = {x: i, y: j, background: defaultBackgroundColor};

        if ($.isNotNull(this.cellsData[i][j])) {
          cellData = this.cellsData[i][j];
        }
        else {
          this.errors.push('An error has been encountered with cell x:' + i + ', y:' + j);
        }
        /*var test = new Unramalak.Cell(hexagon, cellData);

        test.bind('mousedown', function () {
          console.log('click !');
        });

        test.render();*/

        this.cells.add(new Unramalak.Cell(hexagon, cellData));
      }
      odd = !odd;
      // y-radius
      yRadius = hexagonCenter.y - hexagon.segments[0].point.y;
      hexagonCenterY += yRadius * 3 + this.cellPadding;
    }
    // build units
    /*var firstPoint = this.cells.getFirst().getHighPoint();
    var unitOrigin = new paper.Point(firstPoint.x, firstPoint.y + this.radius);
    var unit = new Unramalak.Unit(unitOrigin);
    unit.build();
    this.units.push(unit);

    var originCell = this.cells.getFirst();
    originCell.addUnit(unit);*/
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
    // notify if error has been encountered
    for (var i = 0; i < this.errors.length; i++) {
      this.notify(this.errors[i], 'error');
    }
  },

  /**
   * Unselect cells
   */
  unselect: function () {
//    $.each(this.cells, function (index, cell) {
//      cell.shape.selected = false;
//    });
  },

  /**
   * Update required cells
   */
  update: function () {
    var map = this;
    // if cells have been clicked or drag
    $.each(map.hitCells, function (index, cell) {
      // if a item menu button was pressed
      if (map.menu.hasData('land')) {
        cell.land.type = map.menu.getData('land');
        cell.render();
      }
      /*if (cell.hasUnit()) {
        cell.units[0].shape.selected = true;

        var dimension = new Unramalak.Dimension(10, 10);

        var rules = new Unramalak.Path.Rules(cell.units[0], cell.land);
        var pathManager = new Unramalak.Path.Finder(dimension, rules);

        var krovitch = pathManager.find(new Unramalak.Position(1, 1), 1);

        console.log('Hey je suis là mec !', krovitch);
      }*/
    });
    // then reset hitCells
    this.hitCells = [];
  },

  save: function () {
    var map = this;
    var jsonData;
    var cellsValues = [];

    // save stuff here
    this.cells.each(this, function (cell) {
      cellsValues.push(cell.toJson());
    });
    jsonData = JSON.stringify({profile: this.profile, cells: cellsValues});
    // call ajax url
    $.ajax({
      type: 'POST',
      url: 'save',
      data: 'id=' + this.profile.id + '&data=' + jsonData,
      success: function () {
        map.notify('Map successfully saved !', 'success');
      },
      error: function () {
        map.notify('An error has occurred during map save', 'error');
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
    /*$(document).on('keyup', function (e) {
      // TODO prevent browser from scrolling
       e.stopPropagation();
       e.preventDefault();
       e.stopImmediatePropagation();
    });*/
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

$.Class('Unramalak.Map.Land', {}, {
  type: 'default',
  image: null,

  init: function (type, image) {
    this.type = type;
    this.image = image;
  },

  render: function () {
    var color = defaultBackgroundColor;

    if (this.type == 'sand') {
      color = 'yellow';
    }
    else if (this.type == 'water') {
      color = 'blue';
    }
    //console.log('type', this.type);
    return color;
  }
});