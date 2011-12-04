<div id="map-editor">

  <?php //print_r($map_options);?>

  <div id="map">
    <?php include_partial('map_editor/map', array('map_options' => $map_options)); ?>
  </div>

  <div id="editor-menu">
    <?php include_partial('map_editor/menu', array('menu_options' => $menu_options)); ?>
  </div>
  
</div>

<script type="javascript">
  // Unramalak launch
  $(document).ready(function(){
    var ur = new unramalak("<?php echo url_for('@save_map') ?>");
    ur.launch();
  });
</script>