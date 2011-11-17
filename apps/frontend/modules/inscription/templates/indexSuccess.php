<?php use_helper('Validation'); ?>
<div id="inscription">
	<?php echo form_tag('inscription/subscribe'); ?>
	<fieldset>
		<div class="form-row">
			<?php echo label_for('lbl_name', 'Un nom'); ?>			
			<?php echo input_tag('name', $user->getName()); ?>
			<?php echo form_error('name'); ?>	
		</div>
		<div class="form-row">
			<?php echo label_for('lbl_login', 'Login'); ?>			
			<?php echo input_tag('login', $user->getLogin()); ?>
			<?php echo form_error('login'); ?>	
		</div>
		<div class="form-row">
			<?php echo label_for('lbl_password', 'Mot de passe'); ?>			
			<?php echo input_tag('password', $user->getPassword()); ?>
			<?php echo form_error('password'); ?>	
		</div>
		<div class="form-row">
			<?php echo label_for('lbl_password2', 'Retapez votre mot de passe'); ?>			
			<?php echo input_tag('password2'); ?>
			<?php echo form_error('password2'); ?>	
		</div>
		<div class="form-row">
			<?php echo label_for('lbl_email', 'Email'); ?>			
			<?php echo input_tag('email', $user->getEmail()); ?>
			<?php echo form_error('email'); ?>	
		</div>
		<div class="form-row">
			<?php echo label_for('lbl_avatar', 'Avatar'); ?>			
			<?php echo input_file_tag('avatar'); ?>
			<?php if($user->getAvatar())
					echo $user->getAvatar(); ?>
			<?php echo form_error('avatar'); ?>	
		</div>
		<?php echo submit_tag('M\'inscrire le plus vite possible !!!'); ?>
		<?php echo button_to('Retour', 'accueil/index'); ?>
	</fieldset>
	<?php echo end_form_tag(); ?>
</div>