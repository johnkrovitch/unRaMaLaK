// TODO ça sert a queqchose ????
$.inArrays = function(item, arrays) {
  var inArray = false;

  $.each(arrays, function(index, array) {
    inArray &= ($.inArray(item, array) > -1);
  });
  return $.inArray(item) > -1 && $.inArray(item) > -1
}

Array.prototype.remove = function (value) {
  for (var i = 0; i < this.length; ) {
    if (this[i] === value) {
      this.splice(i, 1);
    } else {
      ++i;
    }
  }
}