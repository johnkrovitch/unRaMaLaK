<div id="editor-menu" class="menu">
  <div id="cell-family-container">

	<?php foreach($menu_options['cell_types_families'] as $cell_family): ?>
	  <ul class="cell-family">

    <?php foreach($cell_family->getCell_Type() as $cell_type): ?>
      <li class="cell-type">
        <?php echo image_tag($cell_type->getBackgroundImage(), array('alt' => $cell_type->getName(), 'class' => 'item')); ?>
      </li>
    <?php endforeach; ?>

    </ul>
  <?php endforeach; ?>
    
  </div>
</div>