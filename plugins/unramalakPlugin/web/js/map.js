/* Map Editor */
$(document).ready(function() {


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

var unramalak = $.jClass({
  editorContext: null,
  editor: null,
  map: null,

  init: function(){
    this.editorContext = new unramalakEditorContext('#editor-menu', '#editor-pointer-menu li.pointer .item', '#cell-family-container li.cell-type .item', '#map-editor-table', '#map-editor-table td');
    this.editor = new unramalakEditor(this.editorContext);
  }
});

var unramalakEditor =  $.jClass({
  context: null,

  init: function(context){
    // bind click on pointerSize change
    $(context.pointerMenu).clickable(context.parentMenu, function(){
      context.pointerSize = $(this).data('pointer-size');
    });
    // add click effects on menu items
    $(context.cellsMenu).clickable(context.parentMenu, function(){
      context.currentCellType = $(this).data('cell-type');
      context.currentCellTypeObject = $(this);
    });
    // add hover effects on map cells
    $(context.mapCells).hoverable().click(function(){
      if(context.hasItemSelected()){
        alert('trace');

        $(this).html($(context.currentCellTypeObject).html());
      }
    });
    //$('#editor-pointer-menu li').addEvent(true, '#editor-pointer-menu li', setMapHoverable);

    this.context = context;
  }
 });

var unramalakEditorContext = $.jClass({
  // vars
  pointerSize: 1,
  currentCellType: 0,
  currentCellTypeObject: null,
  // menu
  parentMenu: null,
  pointerMenu: null,
  cellsMenu: null,
  // map
  mapContainer: null,
  mapCells: null,

  init: function(parentMenu, pointerMenu, cellsMenu, mapContainer, mapCells){
    this.parentMenu = parentMenu;
    this.pointerMenu = pointerMenu;
    this.cellsMenu = cellsMenu;
    this.mapContainer = mapContainer;
    this.mapCells = mapCells;
  },
  hasItemSelected: function(){
    return this.currentCellTypeObject != null;
  }
});

// TODO faire $.unramalak

$(document).ready(function(){
  new unramalak();
});