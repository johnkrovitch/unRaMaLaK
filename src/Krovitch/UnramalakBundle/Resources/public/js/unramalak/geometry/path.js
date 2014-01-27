/**
 * Find a valid path for an unit, according to its movement and to the land
 */
$.Class('Unramalak.Path.Finder', {}, {
    // dimension of searching possibilities, i.e. number of cells
    dimension: null,
    rules: null,

    /**
     * Initialize a path finder with a dimension and rules
     *
     * @param dimension Collection of items to be searched
     * @param rules Rules to decrement movement
     */
    init: function (dimension, rules) {
        this.dimension = dimension;
        this.rules = rules;
    },

    /**
     * Returns valid positions according to movement
     *
     * @param position
     * @param movement
     * @returns {Array}
     */
    find: function (position, movement) {
        var positions = [];
        var remainingMovement = movement;

        while (remainingMovement > 0) {
            // find all potential positions
            var potentialPositions = this.getNearbyPositions(position);
            // get all potential who match the rules (land)
            var validPositions = this.matchRules(potentialPositions);

            if (validPositions.length > 0) {
                positions.push(potentialPositions);
            }
            // TODO decreasing movement points according to tha land type
            // decrease movement points
            remainingMovement--;
        }
        return positions;
    },

    /**
     * Returns matching positions according to the "Rules"
     *
     * @param positions Positions to be matched
     * @returns {Array} Matching positions
     */
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

    /**
     * Return valid positions which are next to a position
     *
     * @param position
     * @returns {Array}
     */
    getNearbyPositions: function (position) {
        // get all nearby positions
        var positions = this.getNearbyPosition(position);
        var validPositions = [];
        var _this = this;

        // we keep only the valid positions
        $.each(positions, function (index, position) {
            var x = position[0];
            var y = position[1];

            // position is valid if it is inside the map
            if (x >= 0 && y >= 0 && x <= _this.dimension.height && y <= _this.dimension.width) {
                validPositions.push(position);
            }
        });
        return validPositions;
    },

    /**
     * Return positions next to a specified position (return position could be invalid)
     *
     * @param position
     * @returns {Array}
     */
    getNearbyPosition: function (position) {
        var x = position.x;
        var y = position.y;

        if (x < 0 || y < 0) {
            throw new Error('Invalid position (x and y should be positive or equal to 0), given : ' + position.toString());
        }
        // a cell can have 6 nearby cells
        return [
            [x - 1, y - 1], // left top
            [x - 1, y], // left
            [x - 1, y + 1], // left bottom
            [x + 1, y + 1], // right bottom
            [x + 1, y], // right
            [x + 1, y - 1] // right top
        ];
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
     *
     * @param unit
     * @param land
     */
    init: function (unit, land) {
        this.land = land;
        this.unit = unit;
    },

    /**
     * Return true if unit can move into this type of land
     *
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