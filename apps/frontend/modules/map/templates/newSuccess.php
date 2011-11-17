<form method="post" action="<?php echo url_for('@new_map') ?>">

  <?php echo $form ?>
  <input type="submit" value="<?php echo __('Créer la map') ?>" />  
  
</form>

<?php echo link_to('Précedent', '@map') ?>