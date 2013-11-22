/**
 * Unramalak.Land
 */
$.Class('Unramalak.Land', {}, {
  type: 'default',
  image: null,

  render: function () {
    var render = {
      type: 'default',
      value: defaultBackgroundColor
    };
    // TODO put textures here
    if (this.type == 'sand') {
      render.type = 'image';
      render.value = 'land_sand';
    }
    else if (this.type == 'water') {
      render.type = 'image';
      render.value = 'land_water';
    }
    else if (this.type == 'plains') {
      render.type = 'image';
      render.value = 'land_plains';
    }
    return render;
  },

  reset: function () {
    this.type = 'default';
  }
});