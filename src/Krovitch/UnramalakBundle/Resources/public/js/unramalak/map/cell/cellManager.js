/**
 * CellManager
 *
 * Handles cells interactions
 *
 */
$.Class('Unramalak.Map.CellManager', {}, {
    menuData: [],

    /**
     * Bind CellManager events :
     *   - cellClick
     *   - ...
     */
    bind: function () {
        EventManager.subscribe(UNRAMALAK_MAP_CELL_CLICK, this.onCellClick, [], this);
        EventManager.subscribe(UNRAMALAK_MENU_ITEM_CLICK, this.onMenuItemClick, [], this);
    },

    /**
     * Interactions on cell click
     *
     * @param mouseEvent
     */
    onCellClick: function (mouseEvent) {
        // on left click, we select a cell
        if (mouseEvent.isLeftClick()) {
            mouseEvent.data.cell.select();
        }
    },

    onMenuItemClick: function (event) {

        if (event.data.type == 'land') {
            this.menuData = event.data;


            console.log('?');
        }


    }
});