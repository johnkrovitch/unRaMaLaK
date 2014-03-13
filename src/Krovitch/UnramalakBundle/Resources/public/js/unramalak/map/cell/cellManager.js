/**
 * CellManager
 *
 * Handles cells interactions
 *
 */
$.Class('Unramalak.Map.CellManager', {}, {
    /**
     * Map cells collection
     *
     * @property {Unramalak.CellCollection}
     */
    cells: null,
    menuData: null,

    /**
     * @constructor
     */
    init: function () {
        //  init cell collections
        this.cells = new Unramalak.CellCollection();
    },

    /**
     * Bind CellManager events :
     *   - cell click
     *   - menu item click
     */
    bind: function () {
        this.cells.bind();
        EventManager.subscribe(UNRAMALAK_MAP_CELL_CLICK, this.onCellClick, [], this);
        EventManager.subscribe(UNRAMALAK_MENU_ITEM_CLICK, this.onMenuItemClick, [], this);
        EventManager.subscribe(UNRAMALAK_MENU_DESELECT, this.onMenuItemClick, [], this);
        EventManager.subscribe(UNRAMALAK_MAP_ADD_UNIT, this.onAddUnitClick, [], this);
        EventManager.subscribe(UNRAMALAK_MAP_RASTER_RENDER, this.onRasterRender, [], this);
    },

    /**
     * Create a cell and add it to the collection
     *
     * @param hexagon paper.js path object
     * @param cellData cell other data
     */
    create: function (hexagon, cellData) {
        this.cells.add(new Unramalak.Cell(hexagon, cellData));
    },

    /**
     * Click on add unit button
     *
     * @param event
     */
    onAddUnitClick: function (event) {
        // by default, the unit will be at 0,0
        var position = new Unramalak.Position(0, 0);
        // creating a default unit
        var unit = new Unramalak.Unit();
        unit.build();
        // attach to a cell
        this.cells.attachUnit(unit, position);
    },

    /**
     * Interactions on cell click
     *
     * @param mouseEvent
     */
    onCellClick: function (mouseEvent) {
        // the guilty cell
        var cell = mouseEvent.data.cell;
        // on left click, we select a cell
        if (mouseEvent.isLeftClick()) {
            // if menu has been clicked, we maybe should alter the cell
            if (this.menuData) {
                // modify land type
                if (this.menuData.type == 'land') {
                    cell.setLandType(this.menuData.value);
                }
            }
            else {
                // default behavior : we select the cell
                cell.select();
            }
        }
    },

    /**
     * On menu item click, the cell manager stores button data
     * @param event
     */
    onMenuItemClick: function (event) {
        this.menuData = event.data;
    },

    onRasterRender: function (event) {
        var raster = event.data;
        // add to paper.js group
        this.cells.group.addChild(raster.shape);
    },

    /**
     * Return an object containing cells data
     *
     * @returns {Array}
     */
    save: function () {
        return this.cells.save();
    }
});