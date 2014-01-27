/**
 * Handle unit interaction with map
 */
$.Class('Unramalak.Unit.UnitManager', {}, {

    displayMovement: function (event, dimension) {
        var cell = event.data.cell;

        console.log('movement cells ?', cell);


        var rules = new Unramalak.Path.Rules(cell.unit, cell.land);
        var finder = new Unramalak.Path.Finder(dimension, rules);
        var test = finder.find(cell.position, cell.unit.movement);

        console.log('rules', rules, 'unit', cell.unit   , 'land', cell.land);


    }

});