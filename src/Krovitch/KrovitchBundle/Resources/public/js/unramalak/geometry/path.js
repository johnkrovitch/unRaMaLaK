/**
 * Find a path for a unit, according to its movement and to the land
 */
$.Class('Unramalak.PathFinder', {}, {
  // dimension of searching possibilities, i.e. number of cells
  dimension: null,

  init: function (dimension) {
    this.dimension = dimension;
  },

  findPath: function (position, movementPoints) {
    // get required cells
    var positions = this.getNearbyPosition(position);
    var validPositions = [];

    $.each(positions, function (index, position) {
      var x = position[0];
      var y = position[1];

      if ((x > 0 && y > 0)) {

      }

    });
  },

  getNearbyPosition: function (position) {
    var x = position.x;
    var y = position.y;

    if (x < 0 || y < 0) {
      throw new Error('Invalid position (x and y should be positive or equal to 0), given : ' + position.toString());
    }
    // a cell can have 6 nearby cells
    var nearbyCellsPositions = [
      [x - 1, y - 1], // left top
      [x - 1, y], // left
      [x - 1, y + 1], // left bottom
      [x + 1, y + 1], // right bottom
      [x + 1, y], // right
      [x + 1, y - 1] // right top
    ];
    return nearbyCellsPositions;
  }


});