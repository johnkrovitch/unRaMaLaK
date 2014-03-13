/**
 * Handle unit interaction with map
 */
$.Class('Unramalak.Unit.UnitManager', {}, {
    /**
     * Map dimension (width x height)
     */
    dimension: null,

    /**
     * Initializes a UnitManager with a specified dimension
     *
     * @constructor
     * @param dimension
     */
    init: function (dimension) {
        this.dimension = dimension;
    },

    /**
     * Bind unit manager events
     */
    bind: function () {
        EventManager.subscribe(UNRAMALAK_UNIT_MOVEMENT_DISPLAY, this.displayMovement, [], this);
    },

    displayMovement: function (event) {
        var cell = event.data.cell;
        var rules = new Unramalak.Path.Rules(cell.unit, cell.land);
        var finder = new Unramalak.Path.Finder(this.dimension, rules);
        var test = finder.find(cell.position, cell.unit.movement);

        console.log('rules', test);


    }

});