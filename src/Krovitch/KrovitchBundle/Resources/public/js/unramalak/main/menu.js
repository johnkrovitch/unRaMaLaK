$.Class('Unramalak.Menu', {}, {
  actions: null,
  actionClicked: [],
  container: null,
  items: null,
  itemClicked: [],
  onSave: null,
  name: '',

  init: function (container, name) {
    this.container = $(container);
    this.name = name;

    if (this.container.length == 0 || this.name.length == 0) {
      throw 'Menu cannot be empty';
    }
    this.items = this.container.find('.menu-item');
    this.actions = this.container.find('.menu-action');
  },

  bind: function (onSave, map) {
    // handle action like save, load...
    this.actions.on('click', function () {
      if ($(this).data('action') == 'save') {
        onSave.call(map||this);
      }
    });
  },

  onItemClick: function (item, e) {
    this.unselect();
    item.addClass('active');
    this.itemClicked.push(item.data('data-value'));
    // stop event propagation
    e.stopPropagation();
    e.preventDefault();
  },

  unselect: function () {
    this.items.each(function () {
      $(this).removeClass('active');
    });
    this.itemClicked = [];
  }
});