// unramalak map API

// use jQuery plugin jclass (old and hard to find now, but do the job). When i'll older, maybe i'll change it.
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
  init: function() {
    // init map context
    this.mapContext = new Unramalak.MapContext({
      startingPoint: new Point(100, 100),
      numberOfSides: 6,
      radius: 50,
      cellPadding: 0
    });
  },

  /**
   * Run application
   */
  run: function() {
    // draw map and bind map's events
    this.map = new Unramalak.Map(this.mapContext);
    this.map.draw();
    this.map.bind();

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





//
$(document).ready(function() {
  var ur = new Unramalak.Application();
  ur.run();
});