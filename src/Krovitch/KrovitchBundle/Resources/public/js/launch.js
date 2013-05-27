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

    $('#flash-container').prepend($(notification));
    this.init();
  },

  launchCounter: function () {
    var alerts = this.alerts;
    setTimeout(function () {
      alerts.fadeOut(1000, function () {
        $(this).remove();
      });
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

// jquery 1.9 remove $.browser features, but we still need it
// so we use a backport from http://jb.demonte.fr/blog/jquery-1-9-0-and-browser/
/**
 * Browser detection for jQuery 1.9
 */
(function ($) {
  var ua = navigator.userAgent.toLowerCase(),
    match = /(chrome)[ \/]([\w.]+)/.exec(ua) ||
      /(webkit)[ \/]([\w.]+)/.exec(ua) ||
      /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(ua) ||
      /(msie) ([\w.]+)/.exec(ua) ||
      ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(ua) || [],
    browser = match[1] || "",
    version =  match[2] || "0";

  $.browser = {};

  if (browser) {
    $.browser[browser] = true;
    $.browser.version = version;
  }

  // Chrome is Webkit, but Webkit is also Safari.
  if ($.browser.chrome) {
    $.browser.webkit = true;
  } else if ($.browser.webkit) {
    $.browser.safari = true;
  }
})(jQuery);