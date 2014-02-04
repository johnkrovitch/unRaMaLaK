/**
 * CellManager
 *
 * Handles cells interactions
 *
 */
$.Class('Unramalak.Map.CellManager', {}, {
    menuData: null,

    /**
     * Bind CellManager events :
     *   - cell click
     *   - menu item click
     */
    bind: function () {
        EventManager.subscribe(UNRAMALAK_MAP_CELL_CLICK, this.onCellClick, [], this);
        EventManager.subscribe(UNRAMALAK_MENU_ITEM_CLICK, this.onMenuItemClick, [], this);
        EventManager.subscribe(UNRAMALAK_MENU_DESELECT, this.onMenuItemClick, [], this);
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

    onMenuItemClick: function (event) {
        this.menuData = event.data;
    }
});