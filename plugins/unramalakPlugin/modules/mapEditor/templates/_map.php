<table id="map-editor-table" cellpadding="0" cellspacing="0">
  <tbody>
  <?php foreach($map_options['cells'] as $rows): ?>

    <tr>
    <?php foreach($rows as $cell): ?>

      <td data-position-x="<?php echo $cell->getPositionX() ?>"
          data-position-y="<?php echo $cell->getPositionY() ?>"
          data-id="<?php echo $cell->getId() ?>"
          data-id-type="<?php echo $cell->getIdType() ?>">
        <?php echo image_tag($cell->getBackgroundImage(), array('alt' => $cell->getIdType())) ?>
      </td>

    <?php endforeach; ?>
    </tr>

  <?php endforeach; ?>
  </tbody>
</table>