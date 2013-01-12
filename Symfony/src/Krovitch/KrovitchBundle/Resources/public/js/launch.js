$(document).on('ready', function() {
  // setup confirm box
  $('a.alert-delete').on('click', function(e) {
    var hasToDeleteItem = confirm('Item will be deleted. Are you sure ?');

    if (!hasToDeleteItem) {
      e.stopPropagation();
      e.preventDefault();
    }
  });

  // setup alerts messages
  var alerts = $('div.alert');

  alerts.find('button.close').on('click', function() {
    $(this).parents('div.alert').remove();
  });
  setTimeout(function() {
    alerts.fadeOut(1000);
  }, 5000);
});