/**
 * Map class
 */
$.Class('Unramalak.Map', {}, {
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
    this.cells = [];
    this.hitCells = [];
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

$.Class('Unramalak.MapContext', {}, {
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