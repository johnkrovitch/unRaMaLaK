<div id="connexion-logged">
	Hey Salut Mister <?php echo $sf_user->getAttribute('name') ?><br />
	<?php echo link_to('Déconnexion', 'connexion/index?disconnect=true') ?>
</div>
