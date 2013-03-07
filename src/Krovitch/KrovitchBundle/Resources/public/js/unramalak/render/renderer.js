/**
 * Handle keyboard's interactions
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