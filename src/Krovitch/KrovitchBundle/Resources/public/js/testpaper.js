// TODO ôter ces globales que je ne saurais voir
var cells = [];
var menu = {
  items: [],
  selected: []
};
var hitObjects = [];

function displayMap()
{
  var mapOptions = {startingPoint: new Point(0, 0), numberOfSides: 6, radius: 50, cellPadding: 0};
  var mapSize = { x: 10, y: 10};
  var odd = false;

  var hexagonCenterX = mapOptions.startingPoint.x;
  var hexagonCenterY =  mapOptions.startingPoint.y;
  var xRadius = 0;
  var yRadius = 0;

  for (var i = 0; i < mapSize.x; i++) {
    var extraCells = 0;
    hexagonCenterX = mapOptions.startingPoint.x;

    if (odd) {
      // case of hexagons : each row is staggered with previous
      // two configurations are possible :
      //TODO translation
      // += : les lignes pairs (0,2,4...) ne commencent pas au bord de la map
      // -= : les lignes impairs (1,3...) ne commencent pas au bord de la map
      hexagonCenterX -= xRadius;
      extraCells = 1;
    }
    for (var j = 0; j < (mapSize.y + extraCells); j++) {

      var hexagonCenter = new Point(hexagonCenterX, hexagonCenterY);
      var hexagon = new Path.RegularPolygon(hexagonCenter, mapOptions.numberOfSides, mapOptions.radius);
      hexagon.fillColor = '#e9e9ff';
      hexagon.strokeColor = '#a2a2f2';

      // x-radius of shape : distance between center and one of his point.
      // distance between this shape and the next is equals to a diameter (plus an optional padding)
      xRadius =  hexagonCenter.x - hexagon.segments[0].point.x;
      hexagonCenterX += xRadius * 2 + mapOptions.cellPadding;

      cells.push(hexagon);
    }
    odd = !odd;
    // y-radius
    yRadius =  hexagonCenter.y - hexagon.segments[0].point.y;
    hexagonCenterY += yRadius * 3 + mapOptions.cellPadding;
  }
}

function displayMenu()
{
  var menuOptions = {menuSize: new Size(150, 500), menuFillColor: 'green', menuStrokeColor: 'blue', buttonSize: [50, 50]};

  var topLeftCorner = new Point(view.viewSize.width - menuOptions.menuSize.width, 0); // menu is on top right
  var rightMapMenu = new Path.Rectangle(topLeftCorner, menuOptions.menuSize);

  rightMapMenu.fillColor = menuOptions.menuFillColor;
  rightMapMenu.strokeColor = menuOptions.strokeColor;

  var button = new Path.Rectangle(topLeftCorner, menuOptions.buttonSize);
  button.fillColor = 'yellow';

  topLeftCorner = new Point(topLeftCorner.x, 100);
  var button2 = new Path.Rectangle(topLeftCorner, menuOptions.buttonSize);
  button2.fillColor = 'red';

  menu.items.push(button, button2);
}

function NOTonMouseDown(event) {
  // The amount of times the mouse has been pressed:
  //console.log(event.count);
  /*var hit = project.hitTest(event.point);

  hit.item.selected = !hit.item.selected;
  //hit.draw();
  console.log(hit);*/
  //hitObjects = [];

}



function NOTonMouseUp(event) {
  // The amount of times the mouse has been released:

  //

  /*if (hit) {
    // hit on the map
    if ($.inArray(hit.item, cells) > -1) {
      hit.item.selected = !hit.item.selected;
    }
    else if ($.inArray(hit.item, menu) > -1) {
      hit.item.selected = !hit.item.selected;
    }
  }*/

  if (hitObjects.length > 0) {

    console.log('hit');

    $.each(hitObjects, function(index, item) {
      item.selected = !item.selected;
    });
  }
  else {

    console.log('no hit');

    var hit = project.hitTest(event.point);

    if (hit) {
      // click in the map
      if ($.inArray(hit.item, cells) > -1) {
        hit.item.selected = !hit.item.selected;

        if (menu.selected.length > 0) {
          hit.item.fillColor = menu.selected[0].fillColor;
        }
      }
      // click in the menu
      if ($.inArray(hit.item, menu.items) > -1) {

        if (!hit.item.selected) {
          hit.item.selected = true;
          menu.selected.push(hit.item);
        }
        else {
          hit.item.selected = false;
          menu.selected.remove(hit.item);
        }
      }
    }
  }

}