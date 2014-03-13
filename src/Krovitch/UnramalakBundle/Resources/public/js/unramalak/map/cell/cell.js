/**
 * BaseCell
 *
 * Has basic binding, rendering functions for cell
 *
 * @name {Unramalak.BaseCell}
 */
Unramalak.Container('Unramalak.BaseCell', {}, {
    land: null,
    position: {},
    raster: null,
    shape: null,

    /**
     * Cell constructor
     *
     * @param shape
     * @param data
     * @constructor
     */
    init: function (shape, data) {
        this.shape = shape;
        this.land = new Unramalak.Land();
        this.unit = null;

        if ($.isNull(data.background)) {
            data.background = defaultBackgroundColor;
        }
        if (data.type) {
            this.land.type = data.type;
        }
        if (data.x != undefined && data.y != undefined) {
            this.position = new Unramalak.Position(parseInt(data.x), parseInt(data.y));
        }
        else {
            throw new Error('Cell has invalid coordinates ' + data.x + ', ' + data.y);
        }
    },

    /**
     * Bind cell event (like mousedown...)
     */
    bind: function () {
        var cell = this;

        // binding paper.js mouseDown event
        this.shape.attach('mousedown', function (paperEvent) {
            // we pass paper.js event and current cell
            var data = {
                paperEvent: paperEvent,
                cell: cell
            };
            // creating mouse event
            var event = new Unramalak.Event.MouseEvent(UNRAMALAK_MAP_CELL_CLICK, data);
            // dispatching
            EventManager.dispatch(UNRAMALAK_MAP_CELL_CLICK, event);
        });
        // on map rendering, we render the cell
        EventManager.subscribe(UNRAMALAK_MAP_RENDER, this.render, [], this);
        EventManager.subscribe(UNRAMALAK_MAP_UNSELECT, this.unselect, [], this);
    },

    /**
     * Render current cell. If cell land has an image render type,
     * it use ImageLoader to load paper raster
     */
    render: function () {
        var render = this.land.render();
        // default render
        if (render.type == 'default') {
            this.shape.fillColor = render.value;
        }
        // texture render
        else if (render.type == 'image') {
            this.shape.fillColor = 'transparent';
            this.raster = new Unramalak.Raster(this.shape, render.value);
            this.raster.render();
            // dispatch event to add the raster to cell paper.js group
            EventManager.dispatch(UNRAMALAK_MAP_RASTER_RENDER, new Unramalak.Event.Event(UNRAMALAK_MAP_RASTER_RENDER, this.raster));
        }
        // default border color
        this.shape.strokeColor = defaultStrokeColor;
        // selection render
        this.shape.selected = this.selected;
        // unit render should be on the last position to be on top of the canvas and not being hide by land raster
        if (this.hasUnit()) {
            this.unit.select(this.selected);
            // units render
            this.unit.render();
        }
    },

    reset: function () {
        // reset land type
        this.land.reset();
        // remove
        this.raster.remove();
    },

    /**
     * Select cell
     */
    select: function () {
        // we inform map that other cells should be unselected
        if (!this.selected) {
            EventManager.dispatch(UNRAMALAK_MAP_UNSELECT);
        }
        // we select/unselect cell
        this.selected = !this.selected;
        // we inform map that it should display cells that unit can reached
        if (this.hasUnit()) {
            if (this.selected) {
                var data = {
                    cell: this,
                    unit: this.unit
                };
                var event = new Unramalak.Event.Event(UNRAMALAK_UNIT_MOVEMENT_DISPLAY, data);
                EventManager.dispatch(UNRAMALAK_UNIT_MOVEMENT_DISPLAY, event);
            }
        }
        this.render();
    },

    /**
     * Return a object containing cell, land and unit data
     */
    save: function () {
        var data = {
            x: this.position.x,
            y: this.position.y,
            land: this.land.save()
        };

        if (this.hasUnit()) {
            data.unit = this.unit.save();
        }
        return data;
    },

    /**
     * Deselect the cell
     */
    unselect: function () {

        if (this.selected) {
            this.selected = false;

            if (this.hasUnit()) {
                this.unit.select(false);
            }
            this.render();
        }
    }
});

/**
 * Cell
 *
 * Handle map behaviors (cells, units...)
 *
 * @name {Unramalak.Cell}
 */
Unramalak.BaseCell('Unramalak.Cell', {}, {
    selected: false,
    unit: null,

    /**
     * Attach an unit to the cell
     *
     * @param unit
     */
    attachUnit: function (unit) {
        // if cell has already a cell, throw an error
        if (this.hasUnit()) {
            throw new Error('Trying to attach an unit to a cell which already have one');
        }
        this.unit = unit;
    },

    /**
     * Return the point on the top of the shape
     * @returns Point
     */
    getHighPoint: function () {
        return this.shape.segments[1].point;
    },

    /**
     * Return true if this container has unit
     *
     * @returns {boolean}
     */
    hasUnit: function () {
        return $.isNotNull(this.unit);
    },

    // TODO refactor this in behaviour
    getPosition: function () {
        return this.shape.position;
    },

    setLandType: function (landType) {
        this.land.type = landType;
        this.render();
    },
});



