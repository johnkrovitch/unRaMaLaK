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
   * @static
   */
  rasters: [],

  /**
   * Load images into body html element
   * @static
   */
  load: function (imagePaths) {
    var ids = [];
    var htmlImages = [];
    // images container, require to be hidden
    var container = $('<div id="unramalak-images-container" class="hidden" />');
    // image template
    var imagesTemplate = '<img src="%src%" id="%id%" class="map-resources" />';

    $.each(imagePaths, function (id, path) {
      htmlImages.push(imagesTemplate.replace('%src%', path).replace('%id%', id));
      ids.push(id);
    });
    // append element to body
    container.append($(htmlImages.join('')));
    $('body').append(container);
  },

  getRaster: function (raster) {
    //if ($.isNull(this.rasters[raster])) {
    //}
    this.rasters[raster] = new paper.Raster(raster);
    return this.rasters[raster];
  },

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
        symbol = paper.project.importSvg(xml.getElementsByTagName("svg")[0]);
      }
    });
    return symbol;
  }
}, {});