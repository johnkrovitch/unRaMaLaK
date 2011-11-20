<table id="map-editor-table" cellpadding="0" cellspacing="0">
  <tbody>
  <?php foreach($map_options['cells'] as $rows): ?>

    <tr>
    <?php foreach($rows as $cell): ?>

      <td><?php echo $cell->getBackgroundImage() ?></td>

    <?php endforeach; ?>
    </tr>
    
  <?php endforeach; ?>
  </tbody>
</table>