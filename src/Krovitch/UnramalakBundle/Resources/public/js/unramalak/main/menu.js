$.Class('Unramalak.Menu', {}, {
    actions: null,
    actionClicked: [],
    container: null,
    items: null,
    data: [],
    onSave: null,

    init: function (container) {
        this.container = $(container);
        this.items = this.container.find('.menu-item');
        this.actions = this.container.find('.menu-action');
    },

    bind: function (onSave, map) {
        var _super = this;
        // click on actions buttons: call map callback
        this.actions.on('click', function () {
            if ($(this).data('action') == 'save') {
                onSave.call(map || this);
            }
        });
        // click on items buttons: save value
        this.items.on('click', function (e) {
            // if other items have been selected, we unselect them and select only current one
            _super.unselect();
            $(this).addClass('active');
            // we save what item was pressed
            _super.data[$(this).data('type')] = $(this).data('value');
            // stop event propagation
            e.stopPropagation();
            e.preventDefault();
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