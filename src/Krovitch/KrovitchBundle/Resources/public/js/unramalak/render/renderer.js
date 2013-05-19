/**
 *
 */
$.Class('Unramalak.Renderer', {}, {

  init: function () {
  },

  animate: function (shape, vector) {
    var renderIndex = 0;

    paper.project.view.onFrame = function () {
      // TODO make 22 a variable depending on frame rate
      if (renderIndex < 22) {
        shape.translate(vector);
        renderIndex++;
      }
    };
    renderIndex = 0;
  }
});

$.Class('Unramalak.ImageLoader', {
  /**
   * Current loaded rasters
   * @static
   */
  rasters: [],

  /**
   * Load images into body html element
   * @static
   */
  load: function (imagePaths) {
    var htmlImages = [];
    // images container, require to be hidden
    var container = $('<div id="unramalak-images-container" class="hidden"></div>');
    // image template
    var imagesTemplate = '<img src="%src%" id="%id%" class="map-resources" />';

    $.each(imagePaths, function (id, path) {
      htmlImages.push(imagesTemplate.replace('%src%', path).replace('%id%', id));
      Unramalak.ImageLoader.rasters.push(id);
    });
    // append element to body
    container.append($(htmlImages.join('')));
    $('body').append(container);
  },

  createRaster: function (name) {
    var raster = null;

    if ($.inArray(name, Unramalak.ImageLoader.rasters) > -1) {
      this.rasters.push(name);
      raster = new paper.Raster(name);
    }
    else {
      throw 'Raster ' + name + ' does not exist. Check your data';
    }
    return raster;
  },

  // TODO improve this features
  loadSvg: function (url) {
    var symbol = null;
    // TODO make a better image loading
    $.ajax({
      type: "GET",
      async: false,
      url: url,
      dataType: "xml",
      success: function(xml){
        //symbol = new paper.Symbol(paper.project.importSvg(xml.getElementsByTagName("svg")[0]));
        symbol = paper.project.importSVG(xml.getElementsByTagName("svg")[0]);
      }
    });
    return symbol;
  }
}, {});

$.Class('Unramalak.Raster', {}, {
  // raster container
  container: null,
  name: '',
  // paper.js raster object
  shape: null,

  /**
   *
   * @param name
   * @param container A positionable container
   */
  init: function (name, container) {
    this.container = container;
    this.name = name;
  },

  bindToContainer: function (event, container) {
    if (!this.shape) {
      throw 'Raster should be rendered before binding it to its container';
    }
    this.shape.attach(event, function (paperEvent) {
      container.shape.fire(event, paperEvent);
    });
  },

  render: function () {
    this.shape = Unramalak.ImageLoader.createRaster(this.name);
    this.shape.setPosition(this.container.getPosition());
    this.bindToContainer('mousedown', this.container);
    this.bindToContainer('mouseup', this.container);
    this.bindToContainer('mousedrag', this.container);
  },

  remove: function () {
    this.shape.remove();
  }
});