<div id="menu-bar-container">
  <div id="menu-bar">
    <ul class="<?php echo $menu_name ?>">

    <?php foreach($menu as $menu_item): ?>
      <li>
        <a <?php echo menuHelper::getCssClass($menu_item['link'], $current_route_name) ?> href="<?php echo menuHelper::url_for($menu_item['link']) ?>"><?php echo $menu_item['label'] ?></a>
      </li>
    <?php endforeach; ?>

    </ul>

    <?php include_component('menu', 'login') ?>
  </div>
</div>