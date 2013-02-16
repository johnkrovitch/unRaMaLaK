var AlertManager = {
  alerts: null,

  init: function () {
    this.alerts = $('div.alert');
    this.alerts.find('button.close').on('click', function () {
      $(this).parents('div.alert').remove();
    });
    if ($.isNotNull(this.alerts)) {
      this.launchCounter();
    }
  },

  addAlert: function (message, type) {
    var notification = '<div class="alert alert-%type%">%message%<button type="button" class="close">×</button></div>';
    notification = notification.replace('%type%', type).replace('%message%', message);

    $('#unramalak').prepend($(notification));
    this.init();
  },

  launchCounter: function () {
    var alerts = this.alerts;
    setTimeout(function () {
      alerts.fadeOut(1000);
    }, 5000);
  }
};

$(document).on('ready', function () {
  // setup confirm box
  $('a.alert-delete').on('click', function (e) {
    var hasToDeleteItem = confirm('Item will be deleted. Are you sure ?');

    if (!hasToDeleteItem) {
      e.stopPropagation();
      e.preventDefault();
    }
  });
  AlertManager.init();
});