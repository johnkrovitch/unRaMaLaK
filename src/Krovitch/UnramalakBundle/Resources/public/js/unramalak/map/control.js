/**
 * Mouse click constants
 */
var MouseClick = {
    leftClick: 0,
    middleClick: 1,
    rightClick: 2
};

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