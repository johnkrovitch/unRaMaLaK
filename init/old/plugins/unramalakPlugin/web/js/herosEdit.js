/* Edition du heros, inventaires... */
var itemHeight = 50; // px
var itemWidth = 50;
var itemPadding = 10;
var paddingRapport = 15; //padding des items et du inventory
var itemPerRow = 4;

function setDraggable(drag){
	$(drag).draggable({revert: true});
}
function setDroppable(drop){
	$(drop).droppable({drop: function(event, ui){
		//quand un item est droppé
		var drag = ui.draggable.clone();		
		if($(this).children('.item').size() == 0){
			ui.draggable.remove();
			$(this).append(drag);			
			$(drag).css('top', '16%').css('left', '32%');
			setDraggable(drag);
		}
	}});	
}
function setMultipleDroppable(drop){
	$(drop).droppable({drop: function(event, ui){
		var nbItems = $(drop).find('.item').size();
		var row = Math.ceil(nbItems / itemPerRow) - 1;		
		var itemsInRow = nbItems % itemPerRow;
		//quand un item est droppé
		var top = row * itemHeight;
		var drag = ui.draggable.clone();		
		ui.draggable.remove();
		$(this).append(drag);		
		$(drag).css('top', top.toString().concat('px')).css('left', '0px');
		setDraggable(drag);
		if(itemsInRow == itemPerRow - 1){
			$(this).append('<div class="floatBreaker" />');
		}
	}});
}

$(document).ready(function(){
	//items draggables
	setDraggable('.item');
	//items droppables
	setDroppable('.droppable');
	setMultipleDroppable('#inventory');

});


