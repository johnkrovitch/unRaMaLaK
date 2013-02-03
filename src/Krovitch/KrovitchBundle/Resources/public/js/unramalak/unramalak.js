// unramalak map API

// use jQuery plugin jclass (old and hard to find now, but do the job).
// notes: init method are called when calling __constructor (new Krovitch() call Krovitch.init())

/**
 *
 */
$.Class('Unramalak.Application', {}, {
  editorContext: null,
  editor: null,
  mapContext: null,
  map: null,
  lastPointClicked: null,

  /**
   * Initialize map and editor objects
   */
  init: function (cells) {
    // Get a reference to the canvas object
    var canvas = document.getElementById('myCanvas');
    // Create an empty project and a view for the canvas:
    paper.setup(canvas);

    // init map context
    this.mapContext = new Unramalak.MapContext({
      startingPoint: new paper.Point(100, 50),
      numberOfSides: 6,
      radius: 50,
      cellPadding: 0,
      menuContainer: '#editor-menu ul.choices',
      cells: cells
    });
  },

  /**
   * Run application
   */
  run: function () {
    // draw map and bind map's events
    this.map = new Unramalak.Map(this.mapContext);
    this.map.draw();
    this.map.bind();
    this.map.preventBubbling();

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
  },

  save: function () {
    var cellsValues = [];
    var jsonData = '';

    // save stuff here
    $(this.map.cells).each(function () {
      var id = 1
      var idType = $(this).getIdType();
      var x = $(this).getPosition('x');
      var y = $(this).getPosition('y');
      var backgroundImage = $(this).getBackgroundImage();

      cellsValues.push({id: id, id_type: idType, x: x, y: y, background_image: backgroundImage});
      jsonData = JSON.stringify(cellsValues, null);
    });
    $.ajax({
      type: 'POST',
      url: this.saveUrl,
      data: 'data=' + jsonData
    });
  }

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