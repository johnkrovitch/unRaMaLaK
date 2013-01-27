$.Class('Unramalak.Geometry.Point', {}, {
  x:null,
  y:null,

  init:function (x, y) {
    this.x = Math.round(x);
    this.y = Math.round(y);
  },
  getX:function () {
    return this.x;
  },
  getY:function () {
    return this.y;
  }
});