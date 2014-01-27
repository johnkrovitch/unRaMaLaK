/**
 * Event
 */
$.Class('Unramalak.Event.Event', {}, {
    /**
     * Event name
     */
    name: '',
    /**
     * Event optional data
     */
    data: null,

    /**
     * Event constructor
     *
     * @param [name]
     * @param [data]
     */
    init: function (name, data) {
        this.name = name;
        this.data = data;
    }
});

/**
 * @name Unramalak.Event.MouseEvent
 */
Unramalak.Event.Event('Unramalak.Event.MouseEvent', {}, {
    // which button was pressed
    hitButton: null,
    // delta (while dragging...)
    delta: null,
    isCtrlPressed: false,

    /**
     * Initialize a MouseEvent with a paper.js event in data
     *
     * @param name
     * @param data
     */
    init: function (name, data) {
        // we should have a paper.js event for a mouse event
        if ($.isNull(data.paperEvent)) {
            throw new Error('MouseEvent shoud have a paper.js event');
        }
        // paper js stuff
        this.delta = data.paperEvent.delta;
        this.isCtrlPressed = data.paperEvent.event.ctrlKey;
        this.hitButton = data.paperEvent.event.button;
        this.type = data.paperEvent.type;
        // regular data
        this.data = data;
    },

    isLeftClick: function () {
        return (this.hitButton == MouseClick.leftClick);
    },

    isRightClick: function () {
        return (this.hitButton == MouseClick.rightClick);
    },

    isCtrl: function () {
        return this.isCtrl;
    }
});