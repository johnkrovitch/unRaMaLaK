<canvas id="map" class="map" width="600" height="600"></canvas>


<div class="map" cellpadding="0" cellspacing="0">


  <?php foreach($map_options['cells'] as $rows): ?>

    <div class="row">
    <?php foreach($rows as $cell): ?>

      <div class="cell" data-position-x="<?php echo $cell->getPositionX() ?>"
          data-position-y="<?php echo $cell->getPositionY() ?>"
          data-id="<?php echo $cell->getId() ?>"
          data-id-type="<?php echo $cell->getIdType() ?>">
        <?php echo image_tag($cell->getBackgroundImage(), array('alt' => $cell->getIdType())) ?>
      </div>

    <?php endforeach; ?>
    </div>

  <div class="floatbreaker"></div>

  <?php endforeach; ?>

</div>