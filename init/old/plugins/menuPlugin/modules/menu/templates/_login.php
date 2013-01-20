<?php if($sf_user->isAuthenticated()): ?>

  <div class="logged">
    <p>T'es connecté, mec !
    <a href="<?php echo url_for('@signout') ?>"><?php echo __('Déconnexion') ?></a></p>
  </div>

<?php else: ?>

  <a href="javascript:void('0');" class="login"><?php echo __('Login') ?></a>

  <div class="login-hidden hidden">
    <h2><?php echo __('Connexion') ?></h2>

    <form action="<?php echo url_for('@signin') ?>" class="login-form" method="post">
      <span>
        <input type="text" name="signin[username]" placeholder="<?php echo __('Taper votre login...') ?>">
        <input type="password" name="signin[password]" placeholder="<?php echo ('Taper votre mot de passe') ?>">
        <input type="submit" value="<?php echo __('Ur') ?>" />
      </span>

      <?php echo $form->renderHiddenFields(); ?>
    </form>
  </div>

<?php endif; ?>