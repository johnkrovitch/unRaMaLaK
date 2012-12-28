// unramalak map API

// use jQuery plugin jclass
// init method are called when calling constructor

/**
 *
 */
$.Class('unramalak.unramalak', {}, {
  editorContext: null,
  editor: null,
  mapContext: null,
  map: null,
  lastPointClicked: null,

  /**
   * Initialize map and editor objects. Require before calling launch()
   */
  init: function() {
    // init map context
    this.mapContext = new unramalak.mapContext({
      startingPoint: new Point(200, 100),
      numberOfSides: 6,
      radius: 50,
      cellPadding: 0
    });
    // init editor context
    this.editorContext = new unramalak.editorContext({
      size: new Size(150, 500),
      origin: new Point(),
      fillColor: 'green',
      strokeColor: 'blue',
      buttonSize: [50, 50]
    });
  },

  /**
   * Launch function required because in function init(), other class methods have not been loaded yet
   */
  launch: function() {
    this.map = new unramalak.map(this.mapContext);
    this.map.draw();
    this.map.bind();

    //var _super = this;
    this.editor = new unramalak.editor(this.editorContext);
    this.editor.draw();
    // map binding
    /*$(this.map).bind('save',function () {
      _super.save();
    }).bind('load',function () {
        // load stuff here
      }).bind('cellClick',function () {
        if (_super.editorContext.hasItemSelected()) {
          _super.map.updateCell(_super.editorContext.pointerSize, $(_super.editorContext.currentCellTypeObject).clone());
        }
      }).bind('move',function () {
        _super.move();
      }).bind('unClick', function () {
        _super.unClick();
      });*/
  }

  /*save:function () {
    var cellsValues = new Array();
    var jsonData = '';

    // save stuff here
    $(this.mapContext.mapCells).each(function () {
      var id = $(this).data('id');
      var idType = $(this).getIdType();
      var x = $(this).getPosition('x');
      var y = $(this).getPosition('y');
      var backgroundImage = $(this).getBackgroundImage();

      cellsValues.push({id:id, id_type:idType, x:x, y:y, background_image:backgroundImage});
      jsonData = JSON.stringify(cellsValues, null);
    });
    $.ajax({
      type:'POST',
      url:this.saveUrl,
      data:'data=' + jsonData
    });
  },*/

  /*move:function () {
    if ($.isNull(this.lastPointClicked)) {
      console.log('last point null here');
      this.lastPointClicked = this.mapContext.click.point;
    } else {
      var xDelta = this.lastPointClicked.getX() - this.mapContext.click.point.getX();
      var yDelta = this.lastPointClicked.getY() - this.mapContext.click.point.getY();

      console.log('x delta', xDelta);
      console.log('y delta', yDelta);

      this.map.move(xDelta, yDelta);
    }
  },

  unClick:function () {
    //console.log('unClick');
    this.lastPointClicked = null;
  }*/
});

$.Class('unramalak.editor', {}, {
  context:null,

  init: function (context) {
    // bind click on pointerSize change
    /*$(context.pointerMenu).clickable(context.pointerMenu, function (element) {
      context.pointerSize = element.data('pointer-size');
    });
    // add click effects on menu items
    $(context.cellsMenu).clickable(context.cellsMenu, function (element) {
      context.currentCellType = element.data('id-type');
      context.currentCellTypeObject = element;
    });*/
    this.context = context;
  },
  draw: function() {
   // var menuOptions = {rightMenuSize: new Size(150, 500), menuFillColor: 'green', menuStrokeColor: 'blue', buttonSize: [50, 50]};

    var topLeftCorner = new Point(view.viewSize.width - this.context.rightMenuOptions.size.width, 0); // menu is on top right
    var rightMapMenu = new Path.Rectangle(topLeftCorner, this.context.rightMenuOptions.size);

    rightMapMenu.fillColor = this.context.rightMenuOptions.menuFillColor;
    rightMapMenu.strokeColor = this.context.rightMenuOptions.strokeColor;

    var button = new Path.Rectangle(topLeftCorner, this.context.rightMenuOptions.buttonSize);
    button.fillColor = 'yellow';

    topLeftCorner = new Point(topLeftCorner.x, 100);
    var button2 = new Path.Rectangle(topLeftCorner, this.context.rightMenuOptions.buttonSize);
    button2.fillColor = 'red';

    //menu.items.push(button, button2);
  }
});

$.Class('unramalak.editorContext', {}, {
  rightMenuOptions: null,

  // vars
  pointerSize:1,
  currentCellType:0,
  currentCellTypeObject:null,
  // menu
  editorMenu:null,
  pointerMenu:null,
  cellsMenu:null,

  init:function (rightMenuOptions, options) {
    this.rightMenuOptions = rightMenuOptions;

    /*this.editorMenu = options.editorMenu;
    this.pointerMenu = options.editorPointerMenu;
    this.cellsMenu = options.cellsMenu;*/
  },
  hasItemSelected:function () {
    return this.currentCellTypeObject != null;
  }
});

/**
 * Map class
 */
$.Class('unramalak.map', {}, {
  context: null,
  cells: null,
  hitCells: null,


  /**
   * Initialize map parameters
   * @param context
   */
  init: function(context) {
    var _super = this;

    this.context = context;
    this.cells = new Array();
    this.hitCells = new Array();
  },

  /**
   * Render the map with options in context
   */
  draw: function() {
    console.log('map.draw', this.context);

    var mapSize = {x: 10, y: 10};
    var odd = false;

    var hexagonCenterX = this.context.startingPoint.x;
    var hexagonCenterY =  this.context.startingPoint.y;
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

        var hexagonCenter = new Point(hexagonCenterX, hexagonCenterY);
        var hexagon = new Path.RegularPolygon(hexagonCenter, this.context.numberOfSides, this.context.radius);
        hexagon.fillColor = '#e9e9ff';
        hexagon.strokeColor = '#a2a2f2';

        // x-radius of shape : distance between center and one of his point.
        // distance between this shape and the next is equals to a diameter (plus an optional padding)
        xRadius =  hexagonCenter.x - hexagon.segments[0].point.x;
        hexagonCenterX += xRadius * 2 + this.context.cellPadding;

        this.cells.push(hexagon);
      }
      odd = !odd;
      // y-radius
      yRadius =  hexagonCenter.y - hexagon.segments[0].point.y;
      hexagonCenterY += yRadius * 3 + this.context.cellPadding;
    }
  },

  bind: function () {
    console.log('map.bind');
    var _super = this;
    //var _project = project;

    $.each(this.cells, function(index, cell) {
      // onMouseDown
      cell.attach('mousedown', function(event) {
        // get current cell state before deselecting all cells
        var selected = this.selected;
        // click on cell: unselect others cells and add clicked cell to selected unless it's already clicked.
        // If <Ctrl> was press, we do not deselect cells
        if (event.key != 'control') {
          _super.unselect();
        }
        if (!selected) {
          _super.hitCells.push(this);
        }
      });
      // onMouseDrag
      cell.attach('mousedrag', function(event) {
        //console.log('mousedrag', event);

        //_super.hitCells.push(event.point);

        var hit = project.hitTest(event.point);
        // if user drag over the map, hit will be null
        if (hit) {
          _super.hitCells.push(hit.item);
        }
      });
      // onMouseUp
      cell.attach('mouseup', function(event) {
        console.log('map.mouseup', this);

        // if cells have been clicked or drag
         $.each(_super.hitCells, function(index, cell) {
          cell.selected = true;
         });
        // then remove this cells from hit cells array
        _super.hitCells.length = 0;
      });
    });
  },

  unselect: function() {
    console.log('map.unselect');

    $.each(this.cells, function(index, cell) {
      cell.selected = false;
    });
  }

  /*updateCell:function (pointerSize, clonedCellTypeObject) {
    //console.log('update', this.cellClickedObject);

    var currentCell = this.cellClickedObject;
    currentCell.empty();
    currentCell.append(clonedCellTypeObject);

    // get coordinates of current clicked cells
    var currentX = currentCell.getPosition('x');
    var currentY = currentCell.getPosition('y');

    // fills other cells according to pointerSize
    if (parseInt(pointerSize) > 0) {

      $(this.context.mapCells).each(function () {
        var x = $(this).getPosition('x');
        var y = $(this).getPosition('y');
        var xValid = (x >= (currentX - pointerSize) && x <= currentX) || (x <= (currentX + pointerSize) && x >= currentX);
        var yValid = (y >= (currentY - pointerSize) && y <= currentY) || (y <= (currentY + pointerSize) && y >= currentY);

        if (xValid && yValid) {
          $(this).empty();
          $(this).append(clonedCellTypeObject.clone());
        }
      });
    }
  },
  move:function (x, y) {
    var htmlMap = $(this.context.mapContainer);
    //var currentTop = ('top');
    //var currentLeft = htmlMap.css('left');

    console.log('top', htmlMap.position().top);
    console.log('left', htmlMap.position().left);

    var unit = 'px';
    var top = htmlMap.position().top + x + unit;
    var left = htmlMap.position().left + y + unit;

    htmlMap.css('top', top).css('left', left);
  }*/
});
/*****************************/

$.Class('unramalak.mapContext', {}, {
  // map paper canvas options
  startingPoint:null,
  numberOfSides:0,
  radius:0,
  cellPadding:0,

  init:function (mapOptions) {
    console.log('mapContext.init', mapOptions);

    this.startingPoint = mapOptions.startingPoint;
    this.numberOfSides = mapOptions.numberOfSides;
    this.radius = mapOptions.radius;
    this.cellPadding = mapOptions.cellPadding;
  }
});

$.Class('unramalak.geometry.point', {}, {
  x:null,
  y:null,

  init:function (x, y) {
    this.x = Math.round(x);
    this.y = Math.round(y);
  },
  getX:function () {
    return this.x;
  },
  getY:function () {
    return this.y;
  }
});

$.Class('unramalak.click', {}, {
  point:null,
  mouseButton:null,

  init:function (x, y, mouseButton) {
    this.point = new unramalak.point(x, y);
    this.mouseButton = mouseButton;
  }
});

$(document).ready(function() {
  //displayMap();
  //displayMenu();

  var ur = new unramalak.unramalak();
  ur.launch();
});