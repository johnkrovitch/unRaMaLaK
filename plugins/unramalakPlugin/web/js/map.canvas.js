console.isDebug = true;

console.debug = function(){
  if(console.isDebug){
    console.log(arguments);
  }
}

$(document).ready(function(){
  console.log('canvas !!!');

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

  var origin = new unramalak.point(10, 10);
  var canvas = new unramalak.canvas.canvas({canvasId: 'map', originPoint: origin});

  console.debug(canvas);

  var square = new unramalak.canvas.shape(canvas.context2d, {originPoint: origin, numberOfSides: 3, sideLength: 100});
  square.draw({fill: true, stroke: true});

});

/**
 * Class canvas
 */
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

/**
 * Shape
 */
$.Class('unramalak.canvas.shape', {}, {
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
    var radius = Math.PI * this.numberOfSides;
    var sideRadius = 360;

    //radius = Math.PI * 2;

    this.points.push(this.originPoint);
    console.debug('radius', radius);



    for(var i = 1; i < this.numberOfSides; i++){
      // conversion from polar coordinates to cartesian
      var x = this.sideLength * Math.cos(radius * i);
      var y = this.sideLength * Math.sin(radius * i);

      console.debug('x', Math.round(x));
      console.debug('y', Math.round(y));
      // but origins is previous point
      x+= this.originPoint.getX();
      y+= this.originPoint.getY();

      this.points.push(new unramalak.point(x, y));
      sideRadius-= radius;
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
  originPoint: null
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