<div id="connexion-logged">
<?php if($sf_user->isAuthenticated()): ?>

	Hey Salut Mister <?php echo $sf_user->getUsername() ?><br />
	<?php echo link_to('Déconnexion', '@signout') ?>	
	<?php else: ?>
	<?php link_to('Se connecter', '@signin') ?>
	
<?php endif; ?>
</div>