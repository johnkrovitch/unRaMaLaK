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
  init: function (canvasId, mapData) {
    // Get a reference to the canvas object
    var canvas = document.getElementById(canvasId);
    // Create an empty project and a view for the canvas:
    paper.setup(canvas);

    // init map context
    this.mapContext = new Unramalak.Map.Context({
      cellPadding: 0,
      data: mapData,
      numberOfSides: 6,
      mapContainer: canvasId,
      menuContainer: '#editor-menu',
      radius: 50,
      startingPoint: new paper.Point(100, 50)
    });
  },

  /**
   * Run application
   */
  run: function () {
    // draw map and bind map's events
    this.map = new Unramalak.Map(this.mapContext);
    //this.map.draw();
    this.map.load();

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