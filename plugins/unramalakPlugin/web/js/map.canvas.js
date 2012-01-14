
$(document).ready(function(){
  console.log('canvas !!!');

  /*var canvas = document.getElementById('map');

  console.log(canvas);

  var context = canvas.getContext('2d');

  context.strokeRect(0,0,10, 10);

  context.beginPath();
  context.moveTo(200, 200);
  context.lineTo(400, 400);
  context.lineTo(0, 400);
  context.closePath();
  context.fill();*/

  var origin = new unramalak.point(0, 0);
  var canvas = new unramalak..canvas.canvas({canvasId: 'map', originPoint: origin});

  console.log(canvas);

});


$.Class('unramalak.canvas.canvas', {}, {
  context2d: null,
  originPoint: null,

  init: function(options){
    var canvas = document.getElementById(options.canvasId);

    if(typeof canvas == undefined){
      throw 'Canvas html element not found !';
    }
    if(!canvas.getContext){
      throw 'Canvas is not supported !';
    }
    this.context2d = canvas.getContext('2d');
    this.originPoint = options.originPoint;
  }
});

// Options

$.Class('options.canvas.options', {}, {
  canvasId: '',
  originPoint: null
});
$.Class('unramalak.canvas.drawOptions', {}, {
  fill: false,
  stroke: false,
  pathType: 'line'
});
unramalak.canvas.drawOptions('unramalak.canvas.shapeOptions', {},{
  originPoint: null,
  numberOfSides: 0,
  sideLength: 0
});
/////////

$.Class('unramalak.shape', {}, {
  context: null,
  points: new Array(),
  originPoint: null,
  numberOfSides: 0,
  sideLength: 0,

  init: function(context, shapeOptions){
    this.context = context;
    this.originPoint = shapeOptions.originPoint;
    this.numberOfSides = shapeOptions.numberOfSides;
    this.sideLength = shapeOptions.sideLength;

    // calculates points for shape
    this.processPoints();
  },

  processPoints: function(){
    var radius = 360 / this.numberOfSides;
    this.points.push(this.originPoint);

    for(var i = 0; i < this.numberOfSides; i++){
      // conversion from polar coordiantes to cartesian
      var x = this.sideLength + Math.cos(radius);
      var y = this.sideLength + Math.sin(radius);

      this.points.push(new unramalak.point(x, y));
    }
  },

  draw: function(drawOptions){
    this.context.beginPath();

    for(var i = 0; i < this.points.length; i++){
      var point = this.points[i];

      // move to first point
      if(i == 0){
        this.context.moveTo(point.getX(), point.getY());
      }else{
        this.context.lineTo(point.getX(), point.getY());
      }
    }
    this.context.closePath();

    // additional options
    if(drawOptions.fill){
      this.context.fill();
    }
    if(drawOptions.stroke){
      this.context.stroke();
    }
  }
});

/**
 * Class Shape
 * @extends unramalak.shape
 */
unramalak.shape('unramalak.cell', {}, {

  init: function(context, shapeOptions){
    this._super.init(context, shapeOptions);
  }
});

