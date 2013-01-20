<div id="user_profile">
  <div class="leftcol">
		<div class="avatar">
			<?php echo image_tag($sf_user->getProfile()->getAvatar()); ?>
		</div>
	</div>
	<div class="rightcol">
		<div class="form">		
			<div class="form_line">
			  <label><?php echo __('Nom :')?></label>
				<span><?php echo $sf_user->getUsername(); ?></span>
			</div>
			<div class="form_line">
				<label><?php echo __('Mail :')?></label>
				<?php echo $sf_user->getGuardUser()->getEmailAddress(); ?>
			</div>
			<div class="form_line">
				<?php echo __('Nombre de jours joués :')?>
				<?php echo $sf_user->getNbPlayedDays(); ?>
			</div>			   
		</div>
	</div>
</div>