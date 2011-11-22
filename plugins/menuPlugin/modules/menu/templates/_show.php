<div id="menu-bar">
  <ul>

  <?php foreach($menu as $menu_item): ?>
    <li>
      <a href="<?php echo $menu_item['link'] ?>"><?php echo $menu_item['label'] ?></a>
    </li>
  <?php endforeach; ?>
    
  </ul>
</div>