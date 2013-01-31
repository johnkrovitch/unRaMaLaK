$.Class('Unramalak.Menu', {}, {
  name: '',
  container: null,

  init: function (container, name) {
    this.container = $(container);
    this.name = name;

    if (this.container.length == 0) {
      console.log('Menu should not be empty !');
    }
  },

  build: function () {
    var _super = this;

    this.container.find('li').each(function () {

      $(this).on('click', function () {
        console.log('trigger menu click', _super.name + '.click');
        _super.container.trigger(_super.name + '.click', [$(this).data('type'), $(this).data('value')]);
      });
    });
  }
});