/**
 * Unit class
 */
$.Class('Unramalak.Unit', {}, {
  origin: null,
  shape: null,

  init: function (originPoint) {
    this.origin = originPoint;
  },

  build: function () {
    // set origin point
    var rightLeg = new paper.Path();
    rightLeg.add(this.origin);
    rightLeg.add(new paper.Point(this.origin.x + 20, this.origin.y + 30));

    var leftLeg = new paper.Path();
    leftLeg.add(this.origin);
    leftLeg.add(new paper.Point(this.origin.x - 20, this.origin.y + 30));

    var trunk = new paper.Path();
    trunk.add(this.origin);
    trunk.add(new paper.Point(this.origin.x, this.origin.y - 35));

    var headOrigin = new paper.Point(this.origin.x, this.origin.y - 44);
    var head = new paper.Path.Circle(headOrigin, 10);

    var rightArm = new paper.Path();
    rightArm.add(new paper.Point(headOrigin.x, headOrigin.y + 10));
    rightArm.add(new paper.Point(headOrigin.x - 20, headOrigin.y + 30));

    var leftArm = new paper.Path();
    leftArm.add(new paper.Point(headOrigin.x, headOrigin.y + 10));
    leftArm.add(new paper.Point(headOrigin.x + 20, headOrigin.y + 30));

    this.shape = new paper.Group(rightLeg, leftLeg, trunk, rightArm, leftArm, head);
  },

  render: function () {
    this.shape.strokeColor = 'black';
  }
});