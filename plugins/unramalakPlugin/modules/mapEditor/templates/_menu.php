<div id="cell-family-container">

<?php foreach($menu_options['cell_types_families'] as $cell_family): ?>
  <ul class="cell-family">

  <?php foreach($cell_family->getCell_Type() as $cell_type): ?>
    <li class="cell-type">
      <?php echo image_tag($cell_type->getBackgroundImage(), array('alt' => $cell_type->getName(), 'class' => 'item', 'data-cell-type' => $cell_type->getId())); ?>
    </li>
  <?php endforeach; ?>

  </ul>
<?php endforeach; ?>

</div>

<div id="editor-pointer-menu">

  <ul>
	<?php foreach($menu_options['pointers'] as $pointer): ?>

    <li class="pointer">
      <a data-pointer-size="<?php echo $pointer['size'] ?>" class="item"><?php echo $pointer['label'] ?></a>
    </li>
  <?php endforeach; ?>
	</ul>

</div>

<div class="map-editor-actions">
  <input type="button" class="map-save" value="Sauvegarder"/>
</div>