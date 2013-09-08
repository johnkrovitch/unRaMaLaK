/**
 * Find a valid path for an unit, according to its movement and to the land
 */
$.Class('Unramalak.Path.Finder', {}, {
  // dimension of searching possibilities, i.e. number of cells
  dimension: null,
  rules: null,

  init: function (dimension, rules) {
    this.dimension = dimension;
    this.rules = rules;
  },

  find: function (position, movement) {
    var positions = [];
    var remainingMovement = movement;

    while (remainingMovement > 0) {
      // find all potential positions
      var potentialPositions = this.getNearbyPositions(position);
      console.log('potential positions', potentialPositions);
      // get all potential who match the rules (land)
      var validPositions = this.matchRules(potentialPositions);
      console.log('valid positions', validPositions);
      if (validPositions.length > 0) {
        positions.push(potentialPositions);
      }
      // decrease movement points
      remainingMovement--;
    }
    return positions;
  },

  matchRules: function (positions) {
    var matchingPositions = [];

    for (var positionIndex in positions) {
      // if positions match to the rules (land etc.), we add to valid positions
      if (this.rules.match(positions[positionIndex])) {
        matchingPositions.push(positions[positionIndex]);
      }
    }
    return matchingPositions;
  },

  getNearbyPositions: function (position) {
    // get all nearby positions
    var positions = this.getNearbyPosition(position);
    var validPositions = [];
    var _this = this;

    // we keep only the valid positions
    $.each(positions, function (index, position) {
      console.log('loop positions', position);
      var x = position[0];
      var y = position[1];

      // position is valid if it is inside the map
      if (x >= 0 && y >= 0 && x <= _this.dimension.height && y <= _this.dimension.width) {
        validPositions.push(position);
      }
    });
    return validPositions;
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

/**
 * Rules to move or not according to unit and type of land
 */
$.Class('Unramalak.Path.Rules', {}, {
  land: null,
  unit: null,

  /**
   * Initialize a Rule for given unit and land
   * @param unit
   * @param land
   */
  init: function (unit, land) {
    this.land = land;
    this.unit = unit;
  },

  /**
   * Return true if unit can move into this type of land
   * @returns {boolean}
   */
  match: function () {
    var match = false;
    // check if unit can traverse this type of land
    if (this.unit.canTraverse(this.land)) {
      match = true;
    }
    return match;
  }
});