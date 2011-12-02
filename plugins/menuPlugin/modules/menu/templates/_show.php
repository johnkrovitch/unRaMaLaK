<div id="menu-bar">
  <ul id="main-menu">

  <?php foreach($menu as $menu_item): ?>
    <li>
      <a <?php echo menuHelper::getCssClass($menu_item['link'], $current_route_name) ?> href="<?php echo menuHelper::url_for($menu_item['link']) ?>"><?php echo $menu_item['label'] ?></a>
    </li>
  <?php endforeach; ?>
    
  </ul>
</div>