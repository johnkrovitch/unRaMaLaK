// return true if elt has "clicked" class
$.fn.isClicked = function() {
  return $(this).hasClass('clicked');
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
  $(this).bind('click', function(){

    if($(this).isClicked()){ // two clicks on same element = deselect
      $(this).removeClass('clicked');
    }else{
      // remove any other .clicked in pattern
      if(typeof pattern != undefined){
        $(pattern).each(function(){
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
  }, function(){
    $(this).removeClass('hovered');
  });
	return $(this);
};

$.fn.addHiddenMenu = function(menu){
  var top = $(this).offset().top + $(this).height() + 15;
  var left = $(this).offset().left - 200;
  var unit = 'px';

  $(this).click(function(e){
    $(menu).css('top', top + unit);
    $(menu).css('left', left + unit);
    $(menu).toggle('slow');

    e.stopPropagation();
  });
  $(menu).click(function(e){
    e.stopPropagation();
  });
  $(document).click(function(){
    $(menu).hide('slow');
  });
}

$.fn.getPosition = function(position){
  return $(this).data('position-' + position);
};

$.fn.getBackgroundImage = function(){
  var image = $(this).find('img');
  return image.length > 0 ? image.attr('src') : '';
};

$.fn.getIdType = function(){
  var idType = $(this).find('img').data('cell-type');
  return isNaN(idType) ? '' : idType;
};
