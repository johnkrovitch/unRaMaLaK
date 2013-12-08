/**
 * @namespace {Unramalak.CellCollection}
 *
 */
$.Class('Unramalak.CellCollection', {}, {
    cells: [],
    group: null,
    hitCells: [],

    /**
     * Initialize a new collection
     */
    init: function () {
        this.group = new paper.Group();
    },

    /**
     * Add a cell into collection
     *
     * @param cell
     */
    add: function (cell) {
        var x = cell.data.x;
        var y = cell.data.y;

        if ($.isNull(this.cells[x])) {
            this.cells[x] = [];
        }
        this.cells[x][y] = cell;
        // add to paper.js group for mass manipulations
        this.group.addChild(cell.shape);
    },

    /***
     * Attach a unit to cell
     *
     * @param unit
     * @param {Unramalak.Position} position
     */
    attachUnit: function (unit, position) {
        // get a cell by its position
        var cell = this.get(position);
        // add to paper.js group for mass manipulations
        this.group.addChild(unit.shape);
        // add unit to cell
        cell.attachUnit(unit);
        // refresh cell display
        cell.render();
    },

    /**
     * Loop through items collection
     *
     * @param map
     * @param callback
     */
    each: function (map, callback) {
        var row, column;

        for (row in this.cells) {
            for (column in this.cells[row]) {
                callback.call(map || this, this.cells[row][column]);
            }
        }
    },

    /**
     * Return a cell by its position
     *
     * @param {Unramalak.Position} position
     * @returns {Unramalak.Cell}
     */
    get: function(position) {

        if (this.cells[position.x].length == 0) {
            throw new Error('Unable to find row in cell collection');
        }
        var cell = null;
        var row = this.cells[position.x];

        if (this.cells[position.x][position.y]) {
            cell = row[position.y];
        }
        else {
            throw new Error('Unable to find cell in cell collection');
        }
        return cell;
    },

    /**
     * Return first cell of the collection
     *
     */
    getFirst: function () {
        return (this.cells.length > 0) ? this.cells[0][0] : null;
    },

    getBounds: function () {
        return this.group.getHandleBounds();
    },

    hitCell: function (cell) {
        this.hitCells.push(cell);
    },

    /**
     * Reset cells background to default color
     */
    reset: function () {
        this.group.background = defaultBackgroundColor;
    },

    translate: function (direction) {
        this.group.translate(direction);
    },

    update: function (data) {
        var cellIndex, cell;

        for (cellIndex in this.hitCells) {
            cell = this.hitCells[cellIndex];

            if (data['land']) {

                if (data['land'] == 'remove') {
                    cell.reset();
                    cell.render();
                }
                else {
                    cell.land.type = data['land'];
                    cell.render();
                    this.group.addChild(cell.raster.shape);
                }
            }
        }
        this.hitCells = [];
    },

    /**
     * Render each element of the collection
     */
    render: function () {
        this.each(this, function (cell) {
            cell.render();

            if ($.isNotNull(cell.raster)) {
                this.group.addChild(cell.raster.shape);
            }
        });
    }
});