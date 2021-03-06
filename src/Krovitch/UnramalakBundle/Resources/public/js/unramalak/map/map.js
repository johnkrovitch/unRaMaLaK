var defaultBackgroundColor = '#e9e9ff';
var defaultStrokeColor = '#a2a2f2';
var mapMode = {
    build: 'BUILD_MODE',
    play: 'PLAY_MODE'
};

/**
 * Map class
 */
$.Class('Unramalak.Map.Map', {}, {
    cellsData: [],
    cellPadding: 0,
    // errors encountered during some process
    errors: [],
    hitCells: [],
    keyboardControl: null,
    mouseControl: null,
    /**
     * @property {Unramalak.Map.CellManager}
     */
    cellManager: null,
    unitManager: null,
    menu: null,
    /**
     * According to the mode, map will not act the same (in fact, its not working yet...)
     */
    mode: null,
    numberOfSides: 0,
    onNotify: null,
    profile: {},
    radius: 0,
    renderer: null,
    startingPoint: null,

    /**
     * Initialize map parameters, gathering data from context
     *
     * @param context Execution context. Should contains all data required by map (like canvasId, name, cells data...)
     */
    init: function (context) {
        if ($.isNull(context)) {
            throw new Error('Invalid map context');
        }
        if (context.preventBubbling) {
            this.preventBubbling();
        }
        // load cell data and map profile
        this.load(context);
        // geometric parameters
        this.cellPadding = context.cellPadding;
        this.numberOfSides = context.numberOfSides;
        this.radius = context.radius;
        this.startingPoint = context.startingPoint;
        // create menu
        this.menu = new Unramalak.Menu(context.menuContainer);
        this.hitCells = [];
        this.renderer = new Unramalak.Renderer();
        // initialize managers
        this.unitManager = new Unramalak.Unit.UnitManager(this.profile.dimension);
        this.cellManager = new Unramalak.Map.CellManager();
    },

    /**
     * Load data from context
     *
     * @param context
     */
    load: function (context) {
        // load cells
        if (context.cells) {
            var cellIndex;

            for (cellIndex in context.cells) {
                var cell = context.cells[cellIndex];

                if ($.isNull(this.cellsData[cell.x])) {
                    this.cellsData[cell.x] = [];
                }
                if ($.isNull(this.cellsData[cell.x][cell.y])) {
                    this.cellsData[cell.x][cell.y] = [];
                }
                this.cellsData[cell.x][cell.y] = cell;
            }
        }
        // load map profile
        if (context.profile) {
            this.profile = context.profile;
            this.profile.dimension = new Unramalak.Dimension(context.profile.width, context.profile.height);
        }
        // TODO manage map events loading
    },

    /**
     * Bind map events
     */
    bind: function () {
        this.menu.bind();
        this.cellManager.bind();
        this.unitManager.bind();
        EventManager.subscribe(UNRAMALAK_MAP_REQUIRED_RENDER, this.render, [], this);
        EventManager.subscribe(UNRAMALAK_MAP_SAVE, this.save, [], this);
    },

    /**
     * Creates cells with theirs data
     */
    build: function () {
        // TODO move this code in a separate object
        if (this.numberOfSides != 6) {
            throw new Error('Invalid number of sides (expected 6, got ' + this.numberOfSides + ')');
        }
        // build cells
        var odd = false;
        var hexagonCenterX = this.startingPoint.x;
        var hexagonCenterY = this.startingPoint.y;
        var xRadius = 0;
        var yRadius = 0;

        for (var i = 0; i < this.cellsData.length; i++) {
            hexagonCenterX = this.startingPoint.x;

            if (odd) {
                // case of hexagons : each row is staggered with previous
                // += : odd row started at the edge of the map
                // -= : even row started at the edge of the map
                hexagonCenterX -= xRadius;
            }
            for (var j = 0; j < this.cellsData[i].length; j++) {
                // we build an new hexagonal cell
                var hexagonCenter = new paper.Point(hexagonCenterX, hexagonCenterY);
                var hexagon = new paper.Path.RegularPolygon(hexagonCenter, this.numberOfSides, this.radius);

                // x-radius of shape : distance between center and one of his point.
                // distance between this shape and the next is equals to a diameter (plus an optional padding)
                xRadius = hexagonCenter.x - hexagon.segments[0].point.x;
                hexagonCenterX += xRadius * 2 + this.cellPadding;

                // default cells
                var cellData = {x: i, y: j, background: defaultBackgroundColor};

                if ($.isNotNull(this.cellsData[i][j])) {
                    cellData = this.cellsData[i][j];
                }
                else {
                    // TODO notify with event manager
                    this.errors.push('An error has been encountered with cell x:' + i + ', y:' + j);
                }
                this.cellManager.create(hexagon, cellData);
            }
            odd = !odd;
            // y-radius
            yRadius = hexagonCenter.y - hexagon.segments[0].point.y;
            hexagonCenterY += yRadius * 3 + this.cellPadding;
        }
        // var is not used anymore
        this.cellsData = [];
    },

    /**
     * Dispatch map render event and redraw paper.js view
     */
    render: function () {
        // render event
        var event = new Unramalak.Event.Event(UNRAMALAK_MAP_RENDER);
        // dispatching event to all objects who need render
        EventManager.dispatch(UNRAMALAK_MAP_RENDER, event);
        // paper.js draw
        paper.view.draw();
    },

    /**
     * Save map context (ajax request)
     */
    save: function () {
        var map = this;
        var mapData = Unramalak.Application.createContextFromMap(this, this.cellManager.save());
        var json = JSON.stringify(mapData);
        var url = map.profile.routing.save;

        // call ajax url
        $.ajax({
            type: 'POST',
            url: url,
            data: 'data=' + json,
            success: function () {
                map.notify('Map successfully saved !', 'success');
            },
            error: function () {
                map.notify('An error has occurred during map save', 'error');
            }
        });
    },

    /**
     * Raise on notify event with a message and its type
     *
     * @param message
     * @param type
     */
    notify: function (message, type) {
        var data = {
            message: message,
            type: type
        };
        EventManager.dispatch(UNRAMALAK_NOTIFICATION_NOTIFY, new Unramalak.Event.Event(UNRAMALAK_NOTIFICATION_NOTIFY, data));
    },

    /**
     * Prevents canvas events bubbling
     */
    preventBubbling: function () {
        // TODO move into Application instead of Map
        var stopPropagation = function (e) {
            e.stopImmediatePropagation();
            e.stopPropagation();
            e.preventDefault();
            return false;
        };
        // left, right click and drag
        $('canvas').on('click', stopPropagation)
            .on('contextmenu', stopPropagation)
            .on('drag', stopPropagation);
    }
});


/**
 * Map context
 *
 * A context should allow to reload map at specific state
 *
 */
$.Class('Unramalak.Map.Context', {}, {
    cells: [],
    data: null,
    cellPadding: 0,
    menuContainer: '',
    mode: '',
    numberOfSides: 0,
    preventBubbling: true, // not customizable now
    profile: {
        name: '',
        height: 0,
        width: 0
    },
    radius: 0,
    startingPoint: null,

    init: function (mapOptions) {
        if ($.isNull(mapOptions)) {
            throw new Error('Trying to create a context with empty data');
        }
        this.cellPadding = mapOptions.cellPadding;
        this.data = mapOptions.data;
        this.menuContainer = mapOptions.menuContainer;
        this.numberOfSides = mapOptions.numberOfSides;
        this.radius = mapOptions.radius;
        this.startingPoint = mapOptions.startingPoint;
        this.profile = mapOptions.profile;
        this.cells = mapOptions.cells;
    }
});