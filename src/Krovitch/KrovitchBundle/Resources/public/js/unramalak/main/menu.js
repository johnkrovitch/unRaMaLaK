$.Class('Unramalak.Menu', {}, {
  actionItems: null,
  container: null,
  items: null,
  name: '',

  init: function (container, name) {
    this.container = $(container);
    this.name = name;

    if (this.container.length == 0 || this.name.length == 0) {
      throw 'Menu cannot be empty';
    }
  },

  build: function () {
    var _super = this;
    this.items = this.container.find('.menu-item');
    this.actionItems = this.container.find('.menu-action');

    this.items.each(function () {
      // handle click on type of land
      $(this).on('click', function (e) {

        // if already selected, unselect it instead
        if ($(this).hasClass('selected')) {
          $(this).addClass('selected');
          // trigger unselect event
          _super.container.trigger(_super.name + '.unselect');
        }
        else {
          $(this).addClass('selected');
          // trigger click event
          _super.container.trigger(_super.name + '.click', [$(this).data('type'), $(this).data('value')]);
        }
        // stop event propagation
        e.stopPropagation();
        e.preventDefault();
      });
    });
    // handle action like save, load...
    this.container.find('.menu-action').on('click', function () {
      _super.container.trigger(_super.name + '.' + $(this).data('action'));
    });
  },

  unselect: function () {
    this.items.each(function () {
      $(this).removeClass('selected');
    });
    // trigger unselect event
    this.container.trigger(this.name + '.unselect');
  }
});