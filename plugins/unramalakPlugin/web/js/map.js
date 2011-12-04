// unramalak map API

var unramalak = $.jClass({
  editorContext: null,
  editor: null,
  mapContext: null,
  map: null,
  saveUrl: '',

  init: function(saveUrl){
    this.saveUrl = saveUrl;

    // init map and editor context
    this.editorContext = new unramalakEditorContext({
      editorMenu: '#editor-menu',
      editorPointerMenu: '#editor-pointer-menu li.pointer .item',
      cellsMenu:  '#cell-family-container li.cell-type .item'
    });
    this.mapContext = new unramalakMapContext({
      mapContainer: '#map-editor-table',
      mapCells:  '#map-editor-table td',
      saveButton: '.save-map'
    });
  },

  /**
   * Launch function required because in function init(), other class methods have not been loaded yet
   */
  launch: function(){
    var _super = this;

    this.editor = new unramalakEditor(this.editorContext);
    this.map = new unramalakMap(this.mapContext);

    // map binding
    $(this.map).bind('save', function(){
      _super.save();
    }).bind('load', function(){
      // load stuff here
    }).bind('cellClick', function(){
      if(_super.editorContext.hasItemSelected()){
        _super.map.updateCell(_super.editorContext.pointerSize, $(_super.editorContext.currentCellTypeObject).clone());
      }
    });
  },

  save: function(){
    var cellsValues = new Array();
    var jsonData = '';

    // save stuff here
    $(this.mapContext.mapCells).each(function(){

      var id = $(this).data('id');
      var idType = $(this).getIdType();
      var x = $(this).getPosition('x');
      var y = $(this).getPosition('y');
      var backgroundImage = $(this).getBackgroundImage();

      cellsValues.push({id: id, id_type: idType, x: x, y: y, background_image: backgroundImage});
      jsonData = JSON.stringify(cellsValues, null);
    });
    $.ajax({
      type: 'POST',
      url: this.saveUrl,
      data: 'data=' + jsonData
    });
  }
});

var unramalakEditor =  $.jClass({
  context: null,

  init: function(context){
    // bind click on pointerSize change
    $(context.pointerMenu).clickable(context.pointerMenu, function(element){
      context.pointerSize = element.data('pointer-size');
    });
    // add click effects on menu items
    $(context.cellsMenu).clickable(context.cellsMenu, function(element){
      context.currentCellType = element.data('id-type');
      context.currentCellTypeObject = element;
    });
    this.context = context;
  }
 });

var unramalakEditorContext = $.jClass({
  // vars
  pointerSize: 1,
  currentCellType: 0,
  currentCellTypeObject: null,
  // menu
  editorMenu: null,
  pointerMenu: null,
  cellsMenu: null,

  init: function(options){
    this.editorMenu = options.editorMenu;
    this.pointerMenu = options.editorPointerMenu;
    this.cellsMenu = options.cellsMenu;
  },
  hasItemSelected: function(){
    return this.currentCellTypeObject != null;
  }
});

var unramalakMap = $.jClass({
  cellClickedObject: null,
  context: null,

  init: function(context){
    var _super = this;

    // add hover effects on map cells and cells images copy according to pointerSize
    $(context.mapCells).hoverable(context.mapContainer, context.pointerSize).bind('click', function(){
      // fire event cellClick for unramalak object to update cell
      _super.cellClickedObject = $(this);
      $(_super).trigger('cellClick');
    }).bind('contextmenu', function(e){
        context.setMapClicked(e.pageX, e.pageY);
        e.stopPropagation();
        return false;
    }).bind('mouseup', function(){
      context.setMapNotClicked();
    }).bind('mousemove',function(e){

      if(context.isMapClicked()){
        // TODO stuff here...

      }
    });
    // save map
    $('.map-save').bind('click', function(){
      $(_super).trigger('save');
    });
    this.context = context;
  },

  updateCell: function(pointerSize, clonedCellTypeObject){
    var currentCell = this.cellClickedObject;
    currentCell.empty();
    currentCell.append(clonedCellTypeObject);

    // get coordinates of current clicked cells
    var currentX = currentCell.getPosition('x');
    var currentY = currentCell.getPosition('y');

    // fills other cells according to pointerSize
    if(parseInt(pointerSize) > 0){

      $(this.context.mapCells).each(function(){
        var x = $(this).getPosition('x');
        var y = $(this).getPosition('y');
        var xValid = (x >= (currentX - pointerSize) && x <= currentX) || (x <= (currentX + pointerSize) && x >= currentX);
        var yValid = (y >= (currentY - pointerSize) && y <= currentY) || (y <= (currentY + pointerSize) && y >= currentY);

        if(xValid && yValid){
          $(this).empty();
          $(this).append(clonedCellTypeObject.clone());
        }
      });
    }
  }
});

var unramalakMapContext = $.jClass({
  // map
  mapContainer: null,
  mapCells: null,
  mapContext: null,
  // actions
  saveButton: null,
  mapXClicked: null,
  mapYClicked: null,

  init: function(options){
    this.mapContainer = options.mapContainer;
    this.mapCells = options.mapCells;
    this.saveButton = options.saveButton;
  },

  setMapClicked: function(pageX, pageY){
    this.mapXClicked = pageX;
    this.mapYClicked = pageY;
  },
  setMapNotClicked: function(){
    this.mapXClicked = null;
    this.mapYClicked = null;
  },
  isMapClicked: function(){
    return typeof this.mapXClicked != undefined || typeof this.mapYClicked != undefined;
  }
});