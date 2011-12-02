// return true if elt has "clicked" class
$.fn.isClicked = function() {
  return $(this).hasClass('clicked')
}
// remove class clicked
$.fn.unClick = function(){
	return $(this).removeClass('clicked');
};

function htmlDecode(input){
  var e = document.createElement('div');
  e.innerHTML = input;
  return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
}

$.fn.clickable = function(pattern, callback){
  $(this).click(function(){

    if($(this).isClicked()){ // two clicks on same element = deselect
      $(this).removeClass('clicked');
    }else{
      // remove any other .clicked in pattern
      if(typeof pattern != undefined){
        $(pattern + ' *').each(function(){
          $(this).removeClass('clicked');
        });
      }
      $(this).addClass('clicked');
    }
    // add custom function
    if(typeof callback == 'function'){
      callback($(this));
    }
  });
};

// hover multi cells
$.fn.hoverable = function(pattern, pointerSize){
	$(this).hover(function(){
    $(this).addClass('hovered');

    if(parseInt(pointerSize) > 1){
      
    }



  }, function(){
    $(this).removeClass('hovered');
  });
	return $(this);
};

$.fn.toCellsArray = function(){
  var table_array = new Array(500);
  var rows = $(this).find('tr');
  var i = 0;

  for (i = 0; i < rows.length; i++){
    var j = 0;
    var cells = $(rows[i]).find('td');
    var rows_array = new Array(cells.length);

    for (j = 0; j <= cells.length; j++){
      rows_array[j] = cells[j];
    }
    table_array[i] = rows_array;
  }
  return table_array;
}



$(document).ready(function(){
  //$('body').animate({backgroundPosition: '(224px -119px)'}, 3000, 'swing', function(){ });
});