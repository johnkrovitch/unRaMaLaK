$.Class('Unramalak.Click', {}, {
  point:null,
  mouseButton:null,

  init:function (x, y, mouseButton) {
    this.point = new unramalak.point(x, y);
    this.mouseButton = mouseButton;
  }
});