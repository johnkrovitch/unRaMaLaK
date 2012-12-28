<?php echo link_to('Nouvelle carte', '@new_map') ?>

<table>
	<tr>
		<th>Nom</th>
		<th>Description</th>
		<th></th>
	</tr>
<?php foreach($maps as $map): ?>
  <tr>
    <td><?php echo $map->getName(); ?></td>
    <td></td>
    <td>
       <?php echo link_to(image_tag('charte/editer.png', array('alt' => 'Editer')), '@edit_map', array('query_string' => 'id='.$map->getId())) ?>
       <?php echo link_to(image_tag('charte/supprimer.png', array('alt' => 'Supprimer')), '@delete_map', array('query_string' => 'id='.$map->getId(), 'confirm' => 'Supprimer cet map ?')) ?>
     </td>
  </tr>
<?php endforeach; ?>
</table>