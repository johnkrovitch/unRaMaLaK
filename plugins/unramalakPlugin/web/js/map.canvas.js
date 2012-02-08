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

  var origin = new unramalak.geometry.point(10, 10);
  var canvas = new unramalak.canvas.canvas({canvasId: 'map', originPoint: origin});

  console.debug(canvas);

  var shapeOrigin = new unramalak.geometry.point(150, 150);
  var square = new unramalak.canvas.shape(canvas.context2d, {originPoint: shapeOrigin, numberOfSides: 3, sideLength: 100});
  square.draw({fill: true, stroke: true});

  shapeOrigin = new unramalak.geometry.point(150, 400);
  var test = new unramalak.canvas.shape(canvas.context2d, {originPoint: shapeOrigin, numberOfSides: 4, sideLength: 100});
  test.draw({fill: true, stroke: true});

  shapeOrigin = new unramalak.geometry.point(400, 150);
  var lol = new unramalak.canvas.shape(canvas.context2d, {originPoint: shapeOrigin, numberOfSides: 6, sideLength: 100});
  lol.draw({fill: true, stroke: true});
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
    var x = this.originPoint.getX() - this.sideLength / 2;
    var y = this.originPoint.getY() - this.sideLength / 2;
    console.debug('new shape at origin : ', this.originPoint);

    // insert first point
    var firstPoint = new unramalak.geometry.point(x, y);
    this.points.push(firstPoint);

    // second point : first segment is horizontal
    x = this.originPoint.getX() + this.sideLength / 2;
    var secondPoint = new unramalak.geometry.point(x, y)
    this.points.push(secondPoint);
    console.debug('points before push :', this.points);

    // radius of circle containing shapes
    var radius = Math.sqrt(Math.pow(firstPoint.getX() - this.originPoint.getX(), 2) + Math.pow(firstPoint.getY() - this.originPoint.getY(), 2));
    console.debug('radius', radius);

    for(var i = this.points.length; i < this.numberOfSides; i++){
      var x = radius * Math.cos(angle * (i - 1));
      var y = radius * Math.sin(angle * (i - 1));

      x+= this.points[i - 1].getX();
      y+= this.points[i - 1].getY();
      //x += this.originPoint.getX();
      //y += this.originPoint.getY();

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