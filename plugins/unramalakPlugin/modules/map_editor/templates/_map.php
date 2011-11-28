<table id="map-editor-table" cellpadding="0" cellspacing="0">
  <tbody>
  <?php foreach($map_options['cells'] as $rows): ?>

    <tr>
    <?php foreach($rows as $cell): ?>

      <td data-position-x="<?php echo $cell->getPositionX() ?>" data-position-y="<?php echo $cell->getPositionY() ?>">
        <?php echo image_tag($cell->getBackgroundImage(), array()) ?>
      </td>

    <?php endforeach; ?>
    </tr>
    
  <?php endforeach; ?>
  </tbody>
</table>