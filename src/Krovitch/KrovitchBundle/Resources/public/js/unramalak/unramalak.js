// unramalak map API

// use jQuery plugin jclass (old and hard to find now, but do the job).
// notes: init method are called when calling __constructor (new Krovitch() call Krovitch.init())

/**
 *
 */
$.Class('Unramalak.Application', {}, {
  editorContext: null,
  editor: null,
  mapContext: null,
  map: null,
  lastPointClicked: null,
  renderer: null,

  /**
   * Initialize map and editor objects
   */
  init: function (canvasId, mapData) {
    // Get a reference to the canvas object
    var canvas = document.getElementById(canvasId);
    // Create an empty project and a view for the canvas:
    paper.setup(canvas);

    // init map context
    this.mapContext = new Unramalak.Map.Context({
      cellPadding: 0,
      data: mapData,
      numberOfSides: 6,
      mapContainer: canvasId,
      menuContainer: '#editor-menu',
      radius: 50,
      startingPoint: new paper.Point(100, 50)
    });
  },

  /**
   * Run application
   */
  run: function () {
    // create render
    var renderer = new Unramalak.Renderer();
    // draw map and bind map's events
    this.map = new Unramalak.Map(this.mapContext, renderer);
    this.map.build();
    this.map.bind(this.notify);
    this.map.render();
  },

  notify: function (message, type) {
    AlertManager.addAlert(message, type);
  }
});