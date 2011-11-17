<div id="menu-principal">
  <ul>
  <?php foreach($menu as $menu_item):  
         if(array_key_exists('application', $menu_item)): ?>
     <li>
       <a href="<?php die($menu_item['link']); echo $menu_item['link'] ?>"><?php echo $menu_item['label'] ?></a>
     </li>
         <?php else: ?>
		 <li>
		     <?php echo  link_to(__($menu_item['label']), $menu_item['link']) ?>
		 </li>
		     <?php endif; 
         endforeach; ?>    
  </ul>
</div>