/*$.Class('Unramalak.Click', {}, {
 point:null,
 mouseButton:null,

 init:function (x, y, mouseButton) {
 this.point = new unramalak.point(x, y);
 this.mouseButton = mouseButton;
 }
 });*/

/**
 * Handle keyboard's interactions
 */
$.Class('Unramalak.Control', {}, {
  moveKeys: null,

  init: function () {
    this.moveKeys = {
      'up': ['up', 'z'],
      'down': ['down', 's'],
      'right': ['right', 'd'],
      'left': ['left', 'q']
    };
  },

  bind: function (object) {
    var _this = this;

    paper.tool.onKeyUp = function(event) {
      _this.onKeyUp(event, object);
    };
  },

  onKeyUp: function (event, target) {
    var _this = this;
    var hasToMove = false;

    for (var direction in this.moveKeys) {
      for (var key in this.moveKeys[direction]) {
        if (event.key == this.moveKeys[direction][key]) {
          hasToMove = true;
          break;
        }
      }
    }
    var count = 0;

    // TODO ugly, should be rewrite
    if (hasToMove) {
      var delta = _this.getDeltaForKey(event.key);

      paper.project.view.onFrame = function () {
        if (count < 22) {
          target.translate(delta);
          count++;
        }
      };
      count = 0;
    }
  },

  getDeltaForKey: function (key) {
    var delta = {x: 0, y: 0};
    var pitch = 4;

    if ($.inArray(key, this.moveKeys.up) > -1) {
      delta.y = -pitch;
    }
    if ($.inArray(key, this.moveKeys.down) > -1) {
      delta.y = pitch;
    }
    if ($.inArray(key, this.moveKeys.left) > -1) {
      delta.x = -pitch;
    }
    if ($.inArray(key, this.moveKeys.right) > -1) {
      delta.x = pitch;
    }
    return delta;
  }
});