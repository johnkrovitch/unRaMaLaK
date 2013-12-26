/**
 * BaseCell
 *
 * Has basic binding, rendering functions for cell
 *
 * @namespace {Unramalak.BaseCell}
 */
Unramalak.Container('Unramalak.BaseCell', {}, {
    land: null,
    shape: null,
    raster: null,
    data: {
        x: null,
        y: null
    },

    init: function (shape, data) {
        this.data = data;
        this.shape = shape;
        this.land = new Unramalak.Land();

        if (!this.data.background) {
            this.data.background = defaultBackgroundColor;
        }
        if (this.data.type) {
            this.land.type = this.data.type;
        }
    },

    bind: function () {
        var cell = this;

        // binding paper.js mouseDown event
        this.shape.attach('mousedown', function (paperEvent) {
            // we pass paper.js event and current cell
            var data = {
                event: paperEvent,
                cell: cell
            };
            var event = new Unramalak.Event.Event(UNRAMALAK_MAP_MOUSE_DOWN, data);
            EventManager.dispatch(event.name, event);
        });
        // on first map rendering, we should render the cell
        EventManager.subscribe(UNRAMALAK_MAP_RENDER, this.render, [], this);
    },

    /**
     * Return a json string of the cell
     * @returns object
     */
    toJson: function () {
        return {
            x: this.data.x,
            y: this.data.y,
            type: this.land.type
        };
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
        this.selected = !this.selected;
        var selected = this.selected;

        if (this.hasUnit()) {
            $.each(this.units, function (index, unit) {
                unit.select(selected);
            });
        }
        // cell must be rendered again
        this.render();
    }
});

/**
 * Cell
 *
 * Handle map behaviors (cells, units...)
 *
 * @namespace {Unramalak.Cell}
 */
Unramalak.BaseCell('Unramalak.Cell', {}, {
    units: [],
    position: null,
    selected: false,

    /**
     * Return the point on the top of the shape
     * @returns Point
     */
    getHighPoint: function () {
        return this.shape.segments[1].point;
    },

    /**
     * Attach an unit to the cell
     *
     * @param unit
     */
    attachUnit: function (unit) {
        this.units.push(unit);
    },

    /**
     * Return true if this container has unit
     * @returns {boolean}
     */
    hasUnit: function () {
        return (this.units.length > 0);
    },

    // TODO refactor this in behaviour
    getPosition: function () {
        return this.shape.position;
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
            this.raster = new Unramalak.Raster(render.value, this);
            this.raster.render();
            /*raster.bind('mousedown', this.shape.onmousedown, this);
             var raster = Unramalak.ImageLoader.createRaster(render.value);
             if (!this.raster) {
             this.raster = raster;
             }
             // TODO make land update (texture change and old raster deletion)
             if (this.raster && this.raster != raster) {
             //this.raster.remove();
             //this.raster = raster;
             }
             var cell = this;
             this.raster.setPosition(this.getPosition());
             this.raster.attach('mousedown', function (e) {
             cell.shape.fire('mousedown', e);
             });
             this.raster.attach('mouseup', function (e) {
             cell.shape.fire('mouseup', e);
             });
             this.raster.attach('mousedrag', function (e) {
             cell.shape.fire('mousedrag', e);
             });*/
        }
        // units render
        for (var index in this.units) {
            this.units[index].render();
        }
        this.shape.strokeColor = defaultStrokeColor;

        // selection render
        this.shape.selected = this.selected;

        if (this.selected && this.hasUnit()) {
            this.unit.select();
        }
    }
});



