<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
  	<div id="header">
  		<?php echo image_tag('logo.png', array('id'=>'logo')); ?>  		  	  				  		
  		<?php include_partial('menu/login'); ?>
  	  <?php include_component('menu','show'); ?>
  	</div>
  	<div id="content">  		
    	<?php echo $sf_content ?>
    </div>
    <div class="floatBreaker"></div>
    <div id="footer">UnRaMaLaK&reg; est une marque déposé de Krovitch&co</div>
  </body>
</html>