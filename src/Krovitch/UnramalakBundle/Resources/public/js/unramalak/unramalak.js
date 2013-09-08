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

  /**
   * Initialize map and editor objects
   */
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


var MapLauncher = {
  dialog: null,

  init: function (dialogSelector, onClickSelector, url) {
    // setting dialog
    this.dialog = $(dialogSelector);
    // binding events
    JsEvent.onReady(JsEvent.onClick, [onClickSelector, this.getMap, [url]]);
  },

  getMap: function (url) {
    // TODO do not depend on Jquery
    $.ajax({
      url: url,
      data: {id: 1},
      dataType: 'json',
      success: MapLauncher.launch,
      error: function (status, machin, error) {
        // TODO gérer les erreurs
        console.log('error', error);
      },
      complete: function () {
        console.log('panda');
      }
    });
  },

  launch: function (data) {
    // TODO make a loader

    // launch unramalak application
    var unramalak = new Unramalak.Application();
    unramalak.load('myCanvas', data.mapData, data.textures);
    unramalak.run();
    // TODO event management to hide dialog when map is loaded (maybe ?)
    MapLauncher.dialog.remove();
  }
};

// TODO comments
var JsEvent = {
  onReady: function (callback, parameters) {
    $(document).on('ready', function () {
      callback.apply(this, parameters);
    });
  },

  onClick: function (selector, callback, parameters) {
    $(selector).on('click', function () {
      callback.apply(this, parameters);
    });
  }
};