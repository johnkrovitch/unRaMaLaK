// unramalak map API



$.Class('unramalak.unramalak', {},{
  editorContext: null,
  editor: null,
  mapContext: null,
  map: null,
  saveUrl: '',
  lastPointClicked: null,

  init: function(saveUrl){
    this.saveUrl = saveUrl;

    // init map and editor context
    this.editorContext = new unramalak.editorContext({
      editorMenu: '#editor-menu',
      editorPointerMenu: '#editor-pointer-menu li.pointer .item',
      cellsMenu:  '#cell-family-container li.cell-type .item'
    });
    this.mapContext = new unramalak.mapContext({
      mapContainer: '.map',
      mapCells:  '.map .cell',
      saveButton: '.save-map'
    });
  },

  /**
   * Launch function required because in function init(), other class methods have not been loaded yet
   */
  launch: function(){
    var _super = this;
    this.editor = new unramalak.editor(this.editorContext);
    this.map = new unramalak.map(this.mapContext);

    // map binding
    $(this.map).bind('save', function(){
      _super.save();
    }).bind('load', function(){
      // load stuff here
    }).bind('cellClick', function(){
      if(_super.editorContext.hasItemSelected()){
        _super.map.updateCell(_super.editorContext.pointerSize, $(_super.editorContext.currentCellTypeObject).clone());
      }
    }).bind('move', function(){
      _super.move();
    }).bind('unClick', function(){
      _super.unClick();
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
  },

  move: function(){
    if($.isNull(this.lastPointClicked)){
      console.log('last point null here');
      this.lastPointClicked = this.mapContext.click.point;
    }else{
      var xDelta = this.lastPointClicked.getX() - this.mapContext.click.point.getX();
      var yDelta = this.lastPointClicked.getY() - this.mapContext.click.point.getY();

      console.log('x delta', xDelta);
      console.log('y delta', yDelta);

      this.map.move(xDelta, yDelta);
    }
  },

  unClick: function(){
    //console.log('unClick');
    this.lastPointClicked = null;
  }
});

$.Class('unramalak.editor', {},{
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

$.Class('unramalak.editorContext', {},{
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

/**
 * Map class
 */
$.Class('unramalak.map', {},{
  cellClickedObject: null,
  context: null,

  init: function(context){
    var _super = this;

    $(context.mapCells).bind('click', function(){
      // fire event cellClick for unramalak object to update cell
      _super.cellClickedObject = $(this);
      $(_super).trigger('cellClick');

    }).bind('contextmenu', function(e){
      console.log('right click');
      context.setMapClick(e.pageX, e.pageY, 'right');

      return false;  // stop right click
    }).bind('mouseup', function(){
      console.log('mouseup');
      context.setMapNotClicked();
      $(_super).trigger('unClick');

      return false;
    }
    ).bind('mousemove',function(e){
      //console.log('mapclicked ?', context.isMapClicked());

      if(context.isMapClicked()){
        context.setMapClick(e.pageX, e.pageY, context.click.mouseButton);
        $(_super).trigger('move');
      }
    }
    ).hoverable(context.mapContainer, context.pointerSize); // add hover effects on map cells and cells images copy according to pointerSize
    // save map
    $('.map-save').bind('click', function(){
      $(_super).trigger('save');
    });
    this.context = context;
  },
  updateCell: function(pointerSize, clonedCellTypeObject){
    //console.log('update', this.cellClickedObject);

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
  },
  move: function(x, y){
    var htmlMap = $(this.context.mapContainer);
    //var currentTop = ('top');
    //var currentLeft = htmlMap.css('left');

    console.log('top', htmlMap.position().top);
    console.log('left', htmlMap.position().left);

    var unit = 'px';
    var top = htmlMap.position().top + x + unit;
    var left = htmlMap.position().left + y + unit;

    htmlMap.css('top', top).css('left', left);
  }
});

$.Class('unramalak.mapContext', {},{
  // map
  mapContainer: null,
  mapCells: null,
  mapContext: null,
  // actions
  saveButton: null,
  click: null,

  init: function(options){
    this.mapContainer = options.mapContainer;
    this.mapCells = options.mapCells;
    this.saveButton = options.saveButton;
  },
  setMapClick: function(pageX, pageY, mouseButton){
    console.log('setMapClick', pageX, pageY);
    this.click = new unramalak.click(pageX, pageY, mouseButton);
  },
  setMapNotClicked: function(){
    this.click = null;
    //console.log('click null', this.click);
  },
  isMapClicked: function(){
    //console.log($.isNull(this.click));
    return !$.isNull(this.click);
  }
});

$.Class('unramalak.point', {},{
  x: null,
  y: null,

  init: function(x, y){
    this.x = x;
    this.y = y;
  },
  getX: function(){
    return this.x;
  },
  getY: function(){
    return this.y;
  }
});

$.Class('unramalak.click', {},{
  point: null,
  mouseButton: null,

  init: function(x, y, mouseButton){
    this.point = new unramalak.point(x, y);
    this.mouseButton = mouseButton;
  }
});