var defaultBackgroundColor = '#e9e9ff';
var defaultStrokeColor = '#a2a2f2';
var mapMode = {
    build: 'BUILD_MODE',
    play: 'PLAY_MODE'
};

/**
 * Map class
 */
$.Class('Unramalak.Map', {}, {
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
        if (context.preventBubbling) {
            this.preventBubbling();
        }
        if ($.isNotNull(context.data)) {
            this.load(context.data);
        }
        // geometric parameters
        this.cellPadding = context.cellPadding;
        this.numberOfSides = context.numberOfSides;
        this.radius = context.radius;
        this.startingPoint = context.startingPoint;
        // create menu
        this.menu = new Unramalak.Menu(context.menuContainer, 'mainMenu');
        //  init cell collections
        this.cells = new Unramalak.CellCollection();
        this.hitCells = [];
        this.renderer = new Unramalak.Renderer();
        // controls
        this.mouseControl = new Unramalak.Control.Mouse();
        // map mode
        this.mode = context.mode;
    },

    /**
     * Load data from context. Those data will be used during map building
     *
     * @param data
     */
    load: function (data) {
        // load cells
        if (data.cells) {
            var cellIndex;

            for (cellIndex in data.cells) {
                if (!data.cells.hasOwnProperty(cellIndex)) {
                    continue;
                }
                var cell = data.cells[cellIndex];

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
        if (data.profile) {
            this.profile = data.profile;
        }
        // TODO manage events loading
    },

    bind: function (onNotify) {

        this.cells.each(function (index, cell) {
            cell.bind();
        });
        var map = this;
        $(document).on('click contextmenu', function () {
            map.menu.unselect();
        });
        // TODO bind events with eventManager
        // binding menu actions
        // bind menu events
        // onclick anywhere but on menu and map, unselect user choice
        this.menu.bind(this.save, this);
        this.onNotify = onNotify;

        EventManager.subscribe('unramalak.map.addUnit', this.addUnit, [null], this);
        EventManager.subscribe(UNRAMALAK_MAP_MOUSE_DOWN, this.mouseControl.onMouseEvent, [], this.mouseControl);
        // binding render
        EventManager.subscribe(UNRAMALAK_MAP_REQUIRED_RENDER, this.render, [], this);
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

        for (var i = 0; i < this.profile.width; i++) {
            hexagonCenterX = this.startingPoint.x;

            if (odd) {
                // case of hexagons : each row is staggered with previous
                // += : odd row started at the edge of the map
                // -= : even row started at the edge of the map
                hexagonCenterX -= xRadius;
            }
            for (var j = 0; j < (this.profile.height); j++) {
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
                    this.errors.push('An error has been encountered with cell x:' + i + ', y:' + j);
                }
                this.cells.add(new Unramalak.Cell(hexagon, cellData));
            }
            odd = !odd;
            // y-radius
            yRadius = hexagonCenter.y - hexagon.segments[0].point.y;
            hexagonCenterY += yRadius * 3 + this.cellPadding;
        }
    },

    move: function (delta) {
        this.cells.translate(delta);
    },

    render: function () {
        var event = new Unramalak.Event.Event(UNRAMALAK_MAP_RENDER);
        EventManager.dispatch(UNRAMALAK_MAP_RENDER, event);

        // we update clicked cell
//        for (var i in this.mouseControl.clickedCells) {
//            var cell = this.mouseControl.clickedCells[i];
//            cell.select();
//        }
//        this.renderer = new Unramalak.Renderer();
//        // draw cells
//        this.cells.render();
//        // draw units
////        this.units.forEach(function (unit) {
////            unit.render();
////        });
        // notify if error has been encountered
        for (var i = 0; i < this.errors.length; i++) {
            this.notify(this.errors[i], 'error');
        }
    },

    /**
     * Unselect cells
     */
    unselect: function () {
//    $.each(this.cells, function (index, cell) {
//      cell.shape.selected = false;
//    });
    },

    /**
     * Update required cells
     */
    update: function () {
        // TODO little improvement here
        var map = this;
        // if cells have been clicked or drag
        $.each(map.cells.hitCells, function (index, cell) {
            // if a item menu button was pressed
            if (map.menu.hasData('land')) {
                cell.land.type = map.menu.getData('land');
                cell.render();
            }
            if (cell.hasUnit()) {
                //cell.units[0].shape.selected = !cell.units[0].shape.selected;

                //var dimension = new Unramalak.Dimension(10, 10);

                //var rules = new Unramalak.Path.Rules(cell.units[0], cell.land);
                //var pathManager = new Unramalak.Path.Finder(dimension, rules);

                //var krovitch = pathManager.find(new Unramalak.Position(1, 1), 1);
            }
        });
        // then reset hitCells
        this.cells.update(this.menu.getData());
        this.cells.hitCells = [];
    },

    save: function () {
        var map = this;
        var jsonData;
        var cellsValues = [];

        // save stuff here
        this.cells.each(this, function (cell) {
            cellsValues.push(cell.toJson());
        });
        jsonData = JSON.stringify({profile: this.profile, cells: cellsValues});
        // call ajax url
        $.ajax({
            type: 'POST',
            url: '/map/save', // TODO make this dynamic
            data: 'id=' + this.profile.id + '&data=' + jsonData,
            success: function () {
                map.notify('Map successfully saved !', 'success');
            },
            error: function () {
                map.notify('An error has occurred during map save', 'error');
            }
        });
    },

    /**
     *
     * @param position
     */
    addUnit: function (position) {

        if ($.isNull(position)) {
            // by default, the unit will be at 0,0
            position = new Unramalak.Position(0, 0);
        }
        // creating a default unit
        var unit = new Unramalak.Unit();
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
            e.stopPropagation();
            e.preventDefault();
        };
        // left, right click and drag
        $('canvas').on('click', stopPropagation)
            .on('contextmenu', stopPropagation)
            .on('drag', stopPropagation);
        /*$(document).on('keyup', function (e) {
         // TODO prevent browser from scrolling
         e.stopPropagation();
         e.preventDefault();
         e.stopImmediatePropagation();
         });*/
    }
});

$.Class('Unramalak.Map.Context', {}, {
    data: null,
    cellPadding: 0,
    mapContainer: '',
    menuContainer: '',
    mode: '',
    numberOfSides: 0,
    preventBubbling: true, // not customizable now
    radius: 0,
    startingPoint: null,

    init: function (mapOptions) {
        this.cellPadding = mapOptions.cellPadding;
        this.data = mapOptions.data;
        this.mapContainer = mapOptions.mapContainer;
        this.menuContainer = mapOptions.menuContainer;
        this.numberOfSides = mapOptions.numberOfSides;
        this.radius = mapOptions.radius;
        this.startingPoint = mapOptions.startingPoint;
    }
});