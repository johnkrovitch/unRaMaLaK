// return true if elt has "clicked" class
$.fn.isClicked = function() {
  return $(this).hasClass('clicked')
}
// remove class clicked
$.fn.unClick = function(){
	return $(this).removeClass('clicked');
};

// change cell state on click
$.fn.clickable = function(single, pattern, callback) {
  $(this).click(function() {
	  // add class "clicked" to clicked object
    if($(this).isClicked()) {	
      $(this).removeClass('clicked');
    }else{
      // delete all already clicked objects in pattern
	  if(single == true){
	    $(pattern).each(function() {
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
  return $(this);
};

// hover multi cells
$.fn.hoverable = function(number_of_cells){
	
	
}

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