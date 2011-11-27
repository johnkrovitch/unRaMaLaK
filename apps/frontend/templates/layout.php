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
  <body class="onLoad">

    <?php include_component('menu','show'); ?>
    
  	<div id="container">
    	<?php echo $sf_content ?>

      <div class="floatBreaker"></div>
      <div id="footer">UnRaMaLaK&reg; est une marque déposée de Krovitch&co&trade;</div>

    </div>

  </body>
</html>