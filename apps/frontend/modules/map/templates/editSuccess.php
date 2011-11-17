<div id="editor">
  <?php echo html_entity_decode($editor->render()); ?>
</div>

<?php echo html_entity_decode($editor->renderMenu()); ?>

<?php echo link_to('Précedent', '@map') ?>