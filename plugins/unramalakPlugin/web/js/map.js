/* Map Editor */
$(document).ready(function() {
  $('#editor-menu .item').clickable(true, '#editor-menu *', setCellType);
  $('#editor-pointer-menu li').clickable(true, '#editor-pointer-menu li', setMapHoverable);
});

/* Change the type of a cell */
function setCellType(element){
  $('#map-table td').click(function() {
    $(this).html(element.clone().unClick());
  });
}

function setMapHoverable(element){
  $('#map-table td').hover(function() {
    var value = element.children('.value').val(); // element est un <li>
    var col = $(this).parent().children().index($(this));
    var row = $(this).parent().parent().children().index($(this).parent());

    var cell = $(this).parent().children();
    var table = $(this).parents('table').toCellsArray();

    for(var i = 0; i < table.length; i++){
      for(var j = 0; j < table[i].length; j++){

        if(i >= (row - value) && i <= (row + value)){
          alert('i:'+i + ' row:'+ row + ' value:'+ value + ' test:' + (i <= (row + value)));
          $(table[i][j]).css('background', 'blue');
        }

        if(i >= row - value && i <= row + value && j >= col + value && j <= col - value){
          //alert('i:'+i+' j:'+j+' row:'+row+' value:'+value);

        }
      }

    }

  });
}

// TODO faire $.unramalak