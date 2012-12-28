console.isDebug = true;

console.debug = function(){
  if(console.isDebug){
    console.log(arguments);
  }
}

$(document).ready(function(){
  console.log('canvas go !!!');

  //var canvas = document.getElementById('map');

  //console.log(canvas);

  //var context = canvas.getContext('2d');

  //context.strokeRect(0,0,10, 10);

  /*context.beginPath();
  context.moveTo(200, 200);
  context.lineTo(400, 400);
  context.lineTo(0, 400);
  context.closePath();
  context.fill();

  context.beginPath();

  context.arc(75,75,50,50,Math.PI/2,true);
  context.closePath();
  context.fill();*/

  var origin = new unramalak.geometry.point(10, 10);
  var canvas = new unramalak.canvas.canvas({canvasId: 'map', originPoint: origin});

  console.debug(canvas);

  var shapeOrigin = new unramalak.geometry.point(150, 150);
  var square = new unramalak.canvas.shape(canvas.context2d, {originPoint: shapeOrigin, numberOfSides: 6, sideLength: 50});
  square.draw({fill: false, stroke: true});
});

/**
 * Class canvas
 */
$.Class('unramalak.canvas.canvas', {}, {

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

/**
 * Shape
 */
$.Class('unramalak.canvas.shape', {}, {

  init: function(context, shapeOptions){
    this.context = context;
    this.originPoint = shapeOptions.originPoint;
    this.numberOfSides = shapeOptions.numberOfSides;
    this.sideLength = shapeOptions.sideLength;
    this.points = new Array();

    console.debug('originPoint', shapeOptions.originPoint);

    // calculates points for shape
    this.processPoints();
  },

  processPoints: function(){
    // angle of each portion of the circle containing the shapes equals to 2PI/Number of sides
    var angle = 2 * Math.PI / this.numberOfSides;
    console.debug('new shape at origin : ', this.originPoint);

    // radius of circle containing shapes
    var radius = Math.abs(this.sideLength / (2 * Math.sin(angle)));
    console.debug('radius', radius);

    for(var i = 1; i <= this.numberOfSides; i++){
      var x = radius * Math.cos((Math.PI - angle)/2 + (i - 1)*angle);
      var y = radius * Math.sin((Math.PI - angle)/2 + (i - 1)*angle);

      // back to the origin coordinates
      x += this.originPoint.getX();
      y += this.originPoint.getY();

      this.points.push(new unramalak.geometry.point(x, y));
      console.debug('push completed :', this.points);
    }
  },

  draw: function(drawOptions){
    this.context.beginPath();
    console.debug('points', this.points);

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
      console.debug('fill');
      this.context.fill();
    }
    if(drawOptions.stroke){
      console.debug('stroke');
      this.context.stroke();
    }
  }
});

/**
 * Class Cell
 * @extends unramalak.shape
 */
unramalak.canvas.shape('unramalak.cell', {}, {

  init: function(context, shapeOptions){
    shapeOptions.numberOfSides = 4;

    this._super.init(context, shapeOptions);
  }
});

// Options
/**
 *
 */
$.Class('options.canvas.options', {}, {
  canvasId: '',
  originPoint: null,
  firstPoint: null
});
/**
 *
 */
$.Class('unramalak.canvas.drawOptions', {}, {
  fill: false,
  stroke: false
  //pathType: 'line'
});
/**
 *
 */
unramalak.canvas.drawOptions('unramalak.canvas.shapeOptions', {},{
  originPoint: null,
  numberOfSides: 0,
  sideLength: 0
});
/////////