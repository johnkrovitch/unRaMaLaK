<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <link href='http://fonts.googleapis.com/css?family=Unlock' rel='stylesheet' type='text/css'>
    <?php include_javascripts() ?>
  </head>
  <body class="onLoad">

    <?php include_component('menu','show'); ?>
    
  	<div id="container">

      <div class="title">
        <p>Bienvenue dans l'antre du Kalamar géant...</p>
        <h1>Unramalak</h1>
      </div>

      <div class="content">
        <?php echo $sf_content ?>
      </div>

      <div id="footer">UnRaMaLaK&reg; est une marque déposée de Krovitch&co&trade;</div>

    </div>

  </body>
</html>