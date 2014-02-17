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
    /**
     * @property {Unramalak.CellCollection}
     */
    cells: null,
    cellsData: [],
    cellPadding: 0,
    // errors encountered during some process
    errors: [],
    hitCells: [],
    keyboardControl: null,
    mouseControl: null,
    cellManager: null,
    unitManager: null,
    menu: null,
    /**
     * According to the mode, map will not act the same
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
        //  init cell collections
        this.cells = new Unramalak.CellCollection();
        this.hitCells = [];
        this.renderer = new Unramalak.Renderer();
        // controls
        //this.mouseControl = new Unramalak.Control.Mouse();
        // initialize managers
        this.unitManager = new Unramalak.Unit.UnitManager();
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
                if (!context.cells.hasOwnProperty(cellIndex)) {
                    continue;
                }
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
        }
        // TODO manage events loading
    },

    /**
     * Bind map events
     *
     * @param onNotify
     */
    bind: function (onNotify) {
        this.cells.each(function (index, cell) {
            cell.bind();
        });
        // TODO bind events with eventManager
        this.onNotify = onNotify;

        this.menu.bind();
        this.cellManager.bind();

        EventManager.subscribe('unramalak.map.addUnit', this.addUnit, [], this);
        EventManager.subscribe(UNRAMALAK_UNIT_MOVEMENT_DISPLAY, this.unitManager.displayMovement, [this.cells], this.unitManager);
        EventManager.subscribe(UNRAMALAK_MAP_REQUIRED_RENDER, this.render, [], this);
        EventManager.subscribe(UNRAMALAK_MAP_SAVE, this.save, [], this);
    },

    /**
     * Creates cells with theirs data
     */
    build: function () {
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
                this.cells.add(new Unramalak.Cell(hexagon, cellData));
            }
            odd = !odd;
            // y-radius
            yRadius = hexagonCenter.y - hexagon.segments[0].point.y;
            hexagonCenterY += yRadius * 3 + this.cellPadding;
        }
        // var is not used anymore
        this.cellsData = [];
    },

    move: function (delta) {
        this.cells.translate(delta);
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

        var mapData = Unramalak.Application.createContextFromMap(this, this.cells.save());
        var json = JSON.stringify(mapData);
        var url = map.profile.routing.save;
        console.log('save', json);
        // call ajax url
        $.ajax({
            type: 'POST',
            url: url,
            data: 'data=' + json,
            success: function () {
                // TODO handle with event manager
                map.notify('Map successfully saved !', 'success');
            },
            error: function () {
                // TODO handle with event manager
                map.notify('An error has occurred during map save', 'error');
            }
        });
    },

    /**
     *
     * @param event
     * @param position
     */
    addUnit: function (event, position) {
        if ($.isNull(position)) {
            // by default, the unit will be at 0,0
            position = new Unramalak.Position(0, 0);
        }
        // creating a default unit
        var unit = new Unramalak.Unit();
        unit.build();
        // attach to a cell
        this.cells.attachUnit(unit, position);
    },

    /**
     * Raise on notify event with a message and its type
     * @param message
     * @param type
     */
    notify: function (message, type) {
        this.onNotify(message, type);
    },

    /**
     * Prevents canvas events bubbling
     */
    preventBubbling: function () {
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
    mapContainer: '',
    menuContainer: '',
    mode: '',
    numberOfSides: 0,
    preventBubbling: true, // not customizable now
    profile: {},
    radius: 0,
    startingPoint: null,

    init: function (mapOptions) {
        if ($.isNull(mapOptions)) {
            throw new Error('Trying to create a context with empty data');
        }
        this.cellPadding = mapOptions.cellPadding;
        this.data = mapOptions.data;
        this.mapContainer = mapOptions.mapContainer;
        this.menuContainer = mapOptions.menuContainer;
        this.numberOfSides = mapOptions.numberOfSides;
        this.radius = mapOptions.radius;
        this.startingPoint = mapOptions.startingPoint;
        //this.routing = mapOptions.routing;
        this.profile = mapOptions.profile;
        this.cells = mapOptions.cells;
    }
});