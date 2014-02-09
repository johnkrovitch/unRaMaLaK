/**
 * Menu
 *
 * Manages map toolbar menu
 */
$.Class('Unramalak.Menu', {}, {
    actions: null,
    items: null,
    data: [],

    init: function (container) {
        this.items = $(container).find('.menu-item');
        this.actions = $(container).find('.menu-action');
    },

    /**
     * Bind menu events (click on button, deselect)
     */
    bind: function () {
        var _super = this;
        // click on actions buttons: call map callback
        this.actions.on('click', function () {
            // menu actions should have an event name
            EventManager.dispatch($(this).data('event'));
            $(this).blur();

            return false;
        });
        // click on items buttons: save value
        this.items.on('click', function () {
            // if other items have been selected, we unselect them and select only current one
            _super.unselect();
            $(this).addClass('active');

            // creating a item click event
            var data = {
                type: $(this).data('type'),
                value: $(this).data('value')
            };
            var event = new Unramalak.Event.Event(UNRAMALAK_MENU_ITEM_CLICK, data);
            // dispatch
            EventManager.dispatch(UNRAMALAK_MENU_ITEM_CLICK, event);

            return false;
        });
        $('html:not(canvas)').on('click', function () {
            _super.unselect();
            // triggering event to inform map to clear menu data
            EventManager.dispatch(UNRAMALAK_MENU_DESELECT);
        });
    },

    /**
     * Return true if menu has data. Data are filled when user click on items buttons
     * If type provided, return true if menu has data of this type (ex: land...)
     * @param type {string}
     * @returns {boolean}
     */
    hasData: function (type) {
        return ($.isNull(type)) ? (this.data.length > 0) : this.data.hasOwnProperty(type);
    },

    /**
     * Return menu data. If type provided, return menu data of this type
     * @param type {string}
     * @returns {*}
     */
    getData: function (type) {
        var data = this.data;

        if ($.isNotNull(type)) {
            data = data[type];
        }
        return data;
    },

    /**
     * Unselect menu items
     */
    unselect: function () {
        this.items.each(function () {
            $(this).removeClass('active');
        });
        this.data = [];
    }
});