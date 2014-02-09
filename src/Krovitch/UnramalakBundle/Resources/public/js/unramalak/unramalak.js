// unramalak map API

/**
 * Main application
 */
$.Class('Unramalak.Application', {
    /**
     * Return a context from a map
     *
     * @static
     * @param map
     * @param cellsData
     */
    createContextFromMap: function (map, cellsData) {
        // create context from map data
        var mapOptions = {
            cellPadding: map.cellPadding,
            profile: map.profile,
            cells: cellsData,
            numberOfSides: map.numberOfSides,
            radius: map.radius,
            startingPoint: map.startingPoint
        };
        return new Unramalak.Map.Context(mapOptions);
    }
}, {
    editorContext: null,
    editor: null,
    mapContext: null,
    map: null,
    lastPointClicked: null,
    renderer: null,

    init: function () {
    },

    /**
     * Load a map
     */
    load: function (canvasId, mapData) {
        // get a reference to the canvas object
        var canvas = document.getElementById(canvasId);
        // create an empty project and a view for the canvas:
        paper.setup(canvas);

        // init map context
        this.mapContext = new Unramalak.Map.Context({
            cellPadding: 0,
            data: mapData,
            numberOfSides: 6,
            mapContainer: canvasId,
            menuContainer: '#editor-menu',
            radius: 50,
            preventBubbling: true,
            startingPoint: new paper.Point(100, 50)
        });
    },

    /**
     * Run application
     */
    run: function () {
        // draw map and bind map's events
        this.map = new Unramalak.Map.Map(this.mapContext);
        this.map.build();
        this.map.bind(this.notify);
        this.map.render();
    },

    notify: function (message, type) {
        AlertManager.addAlert(message, type);
    }
});