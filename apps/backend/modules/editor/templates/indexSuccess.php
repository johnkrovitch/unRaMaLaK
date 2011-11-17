<div id="editor">
	<div id="menu">		
		<?php foreach($map->getCells() as $cell): ?>
			<div class="krovitch">
				<?php $cell->render(); ?>
			</div>
		<?php endforeach; ?>
	</div>
	<div id="map">
	
	</div>
</div>