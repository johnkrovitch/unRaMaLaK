// unramalak map API

// use jQuery plugin jclass (old and hard to find now, but do the job).
// notes: init method are called when calling __constructor (new Krovitch() call Krovitch.init())

/**
 * Main application
 */
$.Class('Unramalak.Application', {}, {
  editorContext: null,
  editor: null,
  mapContext: null,
  map: null,
  lastPointClicked: null,
  renderer: null,

  init: function () {
  },

  /**
   * Load a map
   */
  load: function (canvasId, mapData, textures) {
    // get a reference to the canvas object
    var canvas = document.getElementById(canvasId);
    // create an empty project and a view for the canvas:
    paper.setup(canvas);

    // init map context
    this.mapContext = new Unramalak.Map.Context({
      cellPadding: 0,
      data: mapData,
      numberOfSides: 6,
      mapContainer: canvasId,
      menuContainer: '#editor-menu',
      radius: 50,
      preventBubbling: true,
      startingPoint: new paper.Point(100, 50)
    });
    // load textures
    Unramalak.ImageLoader.load(textures);
  },

  /**
   * Run application
   */
  run: function () {
    // draw map and bind map's events
    this.map = new Unramalak.Map(this.mapContext);
    this.map.build();
    this.map.bind(this.notify);
    this.map.render();
  },

  notify: function (message, type) {
    AlertManager.addAlert(message, type);
  }
});