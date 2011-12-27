<div id="map-editor">

  <?php //print_r($map_options);?>

  <div class="map">
    <?php include_partial('mapEditor/map', array('map_options' => $map_options)); ?>
  </div>

  <div id="editor-menu">
    <?php include_partial('mapEditor/menu', array('menu_options' => $menu_options)); ?>
  </div>
  
</div>

<script type="text/javascript">
  // Unramalak launch
  $(document).ready(function(){
    var ur = new unramalak.unramalak("<?php echo url_for('@save_map') ?>");
    ur.launch();
  });
</script>