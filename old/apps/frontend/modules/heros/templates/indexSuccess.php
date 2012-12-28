<div id="heros">
	<h1>Choississez votre élu !</h1>
	<div id="intro">
		<p>Choississez l'élu qui va guider votre peuple à travers les millénaires...</p>
	</div>
	<?php echo form_tag('heros/save'); ?>
	<div id="avatar">
		<p>Choisissez votre avatar :</p>
		<div id="slider-avatar-container">
			<div id="slider-avatar">
				<ul>
				<?php foreach($avatars as $avatar): ?>
					<li><?php echo image_tag($avatar); ?></li>
				<?php endforeach; ?>
				</ul>
			</div>
			<?php echo input_hidden_tag('avatar_id', '0'); ?>
		</div>
	</div>
	<!-- <div id="banniere">
		<div id="slider-banniere-container">
			<div id="slider-banniere">
				<ul>
				<?php /*foreach($bannieres as $banniere): ?>
					<li><?php echo image_tag($banniere); ?></li>
				<?php endforeach; ?>
				</ul>
			</div>
			<?php echo input_hidden_tag('banniere_id', '0');*/ ?>		
		</div>
	</div>-->
	<div id="infos">
		<div class="form-row">
			<?php echo label_for('heros_name', 'Nom :'); ?>
			<?php echo input_tag('heros_name'); ?>
		</div>
		<div class="form-row">
			<?php echo label_for('heros_tree', 'Compétences :'); ?>
			<?php echo radiobutton_tag('heros_tree', '1', true, array()); echo $trees[0]; ?>
			<?php echo radiobutton_tag('heros_tree', '2', true, array()); echo $trees[1]; ?>
			<?php echo radiobutton_tag('heros_tree', '3', true, array()); echo $trees[2]; ?>
		</div>
		<div class="form-row">
			<?php echo label_for('heros_stats', 'Choix des stats :'); ?>
			<?php echo label_for('heros_stats_pt_restants', 'Points restants -> '); ?>
			<div id="rm_points">10</div>
			<?php echo label_for('heros_stats1', $stats[0]); ?>
			<div id="update1">0</div>
			<?php echo input_hidden_tag('hidden1', '0', array()); ?>
			<div id="plusmoins">
				<input type="button" name="plus1" value="+" id="plus1" />
				<input type="button" name="moins1" value="-" id="moins1" />
			</div>
			<?php echo label_for('heros_stats1', $stats[1]); ?>
			<div id="update2">0</div>
			<?php echo input_hidden_tag('hidden2', '0', array()); ?>
			<div id="plusmoins">
				<input type="button" name="plus2" value="+" id="plus2" />
				<input type="button" name="moins2" value="-" id="moins2" />
			</div>
			<?php echo label_for('heros_stats1', $stats[2]); ?>
			<div id="update3">0</div>
			<?php echo input_hidden_tag('hidden3', '0', array()); ?>
			<div id="plusmoins">
				<input type="button" name="plus3" value="+" id="plus3" />
				<input type="button" name="moins3" value="-" id="moins3" />
			</div>
			<br />			
		</div>
	</div>
	<div class="floatBreaker"></div>
	<?php echo submit_tag('J\'ai choisi mon élu'); ?>
	<div id="story"></div>
	<?php echo end_form_tag(); ?>
</div>