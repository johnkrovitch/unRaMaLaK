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
            startingPoint: {x: map.startingPoint.x, y: map.startingPoint.y}
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
        // bind events
        EventManager.subscribe(UNRAMALAK_NOTIFICATION_NOTIFY, this.notify, [], this);
    },

    /**
     * Load a map
     */
    load: function (canvasId, context) {
        // get a reference to the canvas object
        var canvas = document.getElementById(canvasId);
        // create an empty project and a view for the canvas:
        paper.setup(canvas);
        console.log('context', context);
        // default start location
        context.startingPoint = new Unramalak.Position(100, 50);
        // setting future map context
        this.mapContext = context;
    },

    /**
     * Run application
     */
    run: function () {
        // draw map and bind map's events
        this.map = new Unramalak.Map.Map(this.mapContext);
        this.map.build();
        this.map.bind();
        this.map.render();
    },

    notify: function (event) {
        var message = event.data.message;
        var type = event.data.type;

        if (!type) {
            type = 'info';
        }
        AlertManager.addAlert(message, type);
    }
});