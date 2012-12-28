<div id="new-race">
	<?php echo form_tag('race/save'); ?>
	<div id="intro">
		<p>Choississez votre race et entrez dans le monde d'UnRaMaLaK !!!</p> 
	</div>
	<div class="floatBeaker"></div>
	<div id="leftcol">
		<div id="zaloumek">
			<p>Les ZalouM&apos;eKs</p>
			<?php echo radiobutton_tag('race', 1); ?>
		</div>
		<div id="humains">
			<p>Les Humains</p>
			<?php echo radiobutton_tag('race', 2); ?>
		</div>
		<div id="pirates">
			<p>Les Pirates</p>
			<?php echo radiobutton_tag('race', 3); ?>
		</div>
	</div>
	<div id="rightcol">
		<div id="bioptere">
			<p>Les Biopt&egrave;res</p>
			<?php echo radiobutton_tag('race', 4); ?>
		</div>
		<div id="aqualytes">
			<p>Les Aqualytes</p>
			<?php echo radiobutton_tag('race', 5); ?>
		</div>
		<div id="robots">
			<p>Les Robots</p>
			<?php echo radiobutton_tag('race', 6); ?>
		</div>
	</div>
	<div class="floatBreaker"></div>
	<div id="submit">
		<?php echo submit_tag('J\'ai choisi !'); ?>
	</div>
	<?php echo end_form_tag(); ?>
</div>
