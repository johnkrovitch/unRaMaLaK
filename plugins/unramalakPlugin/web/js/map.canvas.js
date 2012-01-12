
$(document).ready(function(){
  console.log('canvas !!!');

  var canvas = document.getElementById('map');

  console.log(canvas);

  var context = canvas.getContext('2d');

  context.strokeRect(0,0,10, 10);

  context.beginPath();
  context.moveTo(200, 200);
  context.lineTo(400, 400);
  context.lineTo(0, 400);
  context.closePath();
  context.fill();
});

