/* Pour faire défiler les images */

$(document).ready(function(){
	$("#slider-avatar").easySlider({
		prevText: 'Previous Slide',
		prevId: 'prevBtn',
		nextText: 'Next Slide',
		nextId: 'nextBtn'
	});
	
	$('#prevBtn').click(function(){
		$('#avatar_id').val(parseInt($('#avatar_id').val()) - 1);
	});
	$('#nextBtn').click(function(){
		$('#avatar_id').val(parseInt($('#avatar_id').val()) + 1);
	});
	
	// en attente car en conflit avec le precedent eS
	/*$("#slider-banniere").easySlider({
		prevText: 'Previous SlideTwo',
		prevId: 'prevBtnTwo',
		nextText: 'Next SlideTwo',
		nextId: 'nextBtnTwo'
	});
	
	$('#prevBtnTwo').click(function(){
		$('#banniere_id').val(parseInt($('#banniere_id').val()) - 1);
	});
	$('#nextBtnTwo').click(function(){
		$('#banniere_id').val(parseInt($('#banniere_id').val()) + 1);
	});*/
	
	function updatePoints(id, sign){
		var value = parseInt($('#update' + id).html());
		var remaining = parseInt($('#rm_points').html());
		
		if(sign == '+' && remaining > 0){
			$('#update' + id).html(value + 1);
			$('#rm_points').html(remaining - 1);
			$('#hidden' + id).val(value + 1);
		}
		else if(sign == '-' && value > 0){
			$('#update' + id).html(value - 1);
			$('#rm_points').html(remaining + 1);
			$('#hidden' + id).val(value - 1);
		}
	}
	
	$('#plus1').click(function(){
		updatePoints('1', '+');
	});
	$('#moins1').click(function(){
		updatePoints('1', '-');
	});
	$('#plus2').click(function(){
		updatePoints('2', '+');
	});
	$('#moins2').click(function(){
		updatePoints('2', '-');
	});
	$('#plus3').click(function(){
		updatePoints('3', '+');
	});
	$('#moins3').click(function(){
		updatePoints('3', '-');
	});
});