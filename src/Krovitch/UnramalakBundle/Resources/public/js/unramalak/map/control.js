/**
 * Mouse click constants
 * @type {{leftClick: number, middleClick: number, rightClick: number}}
 */
var MouseClick = {
    leftClick: 0,
    middleClick: 1,
    rightClick: 2
};

//$.extend(MouseEventManager, EventManager);

/**
 *
 */
$.Class('Unramalak.Control.Mouse', {}, {
    // during drag, javascript does not correctly send button click code,
    // we need to store it
    lastClicked: null,
    // cells clicked
    clickedCells: [],
//
//    // old stuff
//    bind: function (event, target, map, callback) {
//        var mouseControl = this;
//        // bind event on target
//        target.bind(event, function (paperEvent) {
//            // create mouse event object for easier manipulations
//            var mouseEvent = new Unramalak.Control.MouseEvent(paperEvent);
//            // remember what button was clicked (useful during drag)
//            if (event == 'mousedown') {
//                mouseEvent.hitButton = paperEvent.event.button;
//                mouseControl.lastClicked = mouseEvent.hitButton;
//            }
//            else if (event == 'mouseup') {
//                mouseControl.lastClicked = null;
//            }
//            else if (event == 'mousedrag') {
//                mouseEvent.hitButton = mouseControl.lastClicked;
//            }
//            // callback
//            callback.call(map || this, mouseEvent);
//        });
//    },

    onMouseEvent: function (event) {
        // create mouse event according to paper js mouse event
        var paperEvent = event.data.event;
        var mouseEvent = new Unramalak.Control.MouseEvent(paperEvent);

        // remember what button was clicked (useful during drag)
        if (event.name == 'unramalak.map.mousedown') {
            mouseEvent.hitButton = paperEvent.event.button;
            this.lastClicked = mouseEvent.hitButton;
        }
//        else if (event == 'mouseup') {
//            this.lastClicked = null;
//        }
//        else if (event == 'mousedrag') {
//            this.hitButton = mouseControl.lastClicked;
//        }
        console.log('left click ?');

        // on left click, we store the cell which need an update
        if (mouseEvent.isLeftClick()) {
            event.data.cell.select();
        }
    }
});

$.Class('Unramalak.Control.MouseEvent', {}, {
    // which button was pressed
    hitButton: null,
    // delta (while dragging...)
    delta: null,
    isCtrlPressed: false,

    init: function (paperEvent) {
        this.delta = paperEvent.delta;
        this.isCtrlPressed = paperEvent.event.ctrlKey;
        this.type = paperEvent.type;
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

/**
 * Handle keyboard's interactions
 */
$.Class('Unramalak.Keyboard', {}, {
    moveKeys: null,

    init: function () {
        this.moveKeys = {
            'up': ['up', 'z'],
            'down': ['down', 's'],
            'right': ['right', 'd'],
            'left': ['left', 'q']
        };
    },

    bind: function (map, onMove, object) {
        var _this = this;

        paper.tool.onKeyUp = function (event) {
            _this.onKeyUp(event, object, onMove, map);
        };
    },

    onKeyUp: function (event, target, onMove, map) {
        // need to move some units ?
        var move = this.findDirection(event.key);

        if ($.isNotNull(move)) {
            var direction = this.getDirectionVector(move);
            onMove.call(map || this, target, direction);
        }
    },

    /**
     * Try to find key pressed trigger a move
     * @param key
     * @returns {string}
     */
    findDirection: function (key) {
        var direction = '';
        // z,q,s,d or arrows pushed
        var keyBinding = [];
        keyBinding[0] = keyBinding[1] = 'up';
        keyBinding[2] = keyBinding[3] = 'down';
        keyBinding[4] = keyBinding[6] = 'left';
        keyBinding[6] = keyBinding[7] = 'right';

        var boundKeys = [].concat(this.moveKeys.up, this.moveKeys.down, this.moveKeys.left, this.moveKeys.right);
        var keyIndex = boundKeys.indexOf(key);

        if (keyIndex > -1) {
            direction = keyBinding[keyIndex];
        }
        return direction;
    },

    getDirectionVector: function (direction) {
        var vector = {x: 0, y: 0};
        var length = 1;

        if (direction == 'up') {
            vector.y = -length;
        }
        if (direction == 'down') {
            vector.y = length;
        }
        if (direction == 'left') {
            vector.x = -length;
        }
        if (direction == 'right') {
            vector.x = length;
        }
        return vector;
    }
});