<div id="menu-bar">
  <ul class="<?php echo $menu_name ?>">

  <?php foreach($menu as $menu_item): ?>
    <li>
      <a <?php echo menuHelper::getCssClass($menu_item['link'], $current_route_name) ?> href="<?php echo menuHelper::url_for($menu_item['link']) ?>"><?php echo $menu_item['label'] ?></a>
    </li>
  <?php endforeach; ?>

    <li class="login"><a href="javascript:void('0');">Login</a></li>
  </ul>

  <div class="login-hidden hidden">
    <h2><?php echo __('Connexion') ?></h2>

    <form action="<?php echo url_for('@signin') ?>">
      <span>
        <input type="text" name="signin_username" placeholder="Taper votre login...">
        <input type="text" name="signin_password" placeholder="Taper votre mot de passe">
      </span>

      <input type="submit" value="<?php echo __('Go\'NraMaLak') ?>" />
    </form>
  </div>
</div>