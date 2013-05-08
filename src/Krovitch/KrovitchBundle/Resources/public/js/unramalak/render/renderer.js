/**
 *
 */
$.Class('Unramalak.Renderer', {}, {

  init: function () {
  },

  animate: function (shape, vector) {
    var renderIndex = 0;

    paper.project.view.onFrame = function () {
      if (renderIndex < 22) {
        shape.translate(vector);
        renderIndex++;
      }
    };
    renderIndex = 0;
  }
});

$.Class('Unramalak.ImageLoader', {
  rasters: [],

  /**
   * Load images into body html element
   * @static
   */
load: function (imagePaths) {
    var ids = [];
    var htmlImages = [];
    // images container, require to be hidden
    var container = $('<div id="unramalak-images-container" class="hidden" />')
    // image template
    var imagesTemplate = '<img src="%src%" id="%id%" class="map-resources" />';

    $.each(imagePaths, function (id, path) {
      htmlImages.push(imagesTemplate.replace('%src%', path).replace('%id%', id));
      ids.push(id);
    });
    // append element to body
    container.append($(htmlImages.join('')));
    $('body').append(container);

    $.each (ids, function (index, id) {
      Unramalak.ImageLoader.rasters.push(new paper.Raster(id));
    });
  }
}, {});