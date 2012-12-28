<div id="new-player">
<form method="post" action="<?php echo url_for('@new_player') ?>">

	<div class="form-row">
	  <?php echo $form['login']->renderLabel() ?>
		<?php echo $form['login']->render() ?>
	</div>
	<div class="form-row">
	  <?php echo $form['password']->renderLabel() ?>
		<?php echo $form['password']->render() ?>
	</div>
	<div class="form-row">
	  <?php echo $form['confirm_password']->renderLabel() ?>
		<?php echo $form['confirm_password']->render() ?>
	</div>
	<div class="form-row">
	  <?php echo $form['email']->renderLabel() ?>
		<?php echo $form['email']->render() ?>
	</div>
	<div class="form-row">
	  <?php echo $form['first_name']->renderLabel() ?>
		<?php echo $form['first_name']->render() ?>
	</div>
	<div class="form-row">
	  <?php echo $form['last_name']->renderLabel() ?>
		<?php echo $form['last_name']->render() ?>
	</div>
	<div class="form-row">
	  <?php echo $form['birthday']->renderLabel() ?>
		<?php echo $form['birthday']->render() ?>
	</div>
    
  <?php echo $form->renderHiddenFields(); ?>  
  <input type="submit" value="<?php echo __('Entrer dans le jeu') ?>" />
  
</form>
</div>