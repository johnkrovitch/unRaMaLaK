var Admin = {
  init: function () {
    $('.toggle-container').on('click', function () {
      $($(this).data('target')).fadeToggle('fast');

      return false;
    });
  }
};

// launch on document ready
$(document).on('ready', function () {
  Admin.init();
});
