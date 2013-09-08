/**
 * The position of an object in map coordinates system
 */
$.Class('Unramalak.Position', {}, {
  x: 0,
  y: 0,

  init: function (x, y) {
    this.x = x;
    this.y = y;
  }
});

/**
 * Dimension of an object in map coordinates system
 */
$.Class('Unramalak.Dimension', {}, {
  height: 0,
  width: 0,

  init: function (width, height) {
    this.width = width;
    this.height = height;
  }
});