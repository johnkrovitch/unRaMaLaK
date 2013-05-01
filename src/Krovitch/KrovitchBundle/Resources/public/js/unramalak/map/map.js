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
      this.preventBubbling();
    }
    if ($.isNotNull(context.data)) {
      this.load(context.data);
    }
    this.cellPadding = context.cellPadding;
    //this.height = context.data.height;
    //this.name = context.data.name;
    this.numberOfSides = context.numberOfSides;
    this.radius = context.radius;
    this.startingPoint = context.startingPoint;
    //this.width = context.data.width;
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
      console.log('profile', data.profile);
    }
    // TODO manage events loading
  },

  bind: function (onNotify) {
    var _super = this;

    console.log('alert !', this.cells.cells[0][0].shape);

    this.cells.cells[0][0].shape.attach('mousedown', function(){
      console.log('alert !');
    });

    this.cells.each(this, function (cell) {
      //console.log('each ?', cell);
      cell.shape.attach('mousedown', function(){
        console.log('alert !');
      });
      // onMouseDown
      cell.bind('mousedown', function (paperEvent) {
        console.log('update ?', this);
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
        this.cells.add(new Unramalak.Cell(hexagon, cellData));

        console.log('hexagon!', hexagon);

        hexagon.attach('mousedown', function(){
          console.log('alert !');
        });
      }
      odd = !odd;
      // y-radius
      yRadius = hexagonCenter.y - hexagon.segments[0].point.y;
      hexagonCenterY += yRadius * 3 + this.cellPadding;
    }
    console.log('cells ?', this.cells);
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
      cell.shape.onClick =  function(){
        console.log('alert !');
      };
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

  update: function () {
    var _super = this;
    // if cells have been clicked or drag
    $.each(_super.hitCells, function (index, cell) {
      console.log('hit ?');
      // TODO refactor into a event manager
      // if a item menu button was pressed
      if (_super.menu.hasData('land')) {
        cell.setBackground(_super.menu.getData('land'));
        cell.render();
      }
      if (cell.hasUnit()) {
        cell.units[0].shape.selected = true;

        var dimension = new Unramalak.Dimension(10, 10);

        var rules = new Unramalak.Path.Rules(cell.units[0], cell.land);
        var pathManager = new Unramalak.Path.Finder(dimension, rules);

        var krovitch = pathManager.find(new Unramalak.Position(1, 1), 1);

        console.log('Hey je suis là mec !', krovitch);
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
      cellsValues.push(cell.toJson());
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
    /*$('canvas').on('click', function (e) {
      console.log('click ?');
      //e.stopPropagation();
      //e.preventDefault();
    });
    $(document).on('keyup', function (e) {
      // TODO prevent browser from scrolling
      /*console.log('keyup');
       e.stopPropagation();
       e.preventDefault();
       e.stopImmediatePropagation();
       return false;*/
    //});
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
  type: null,
  image: null,

  init: function (type, image) {
    this.type = type;
    this.image = image;
  }
});