<?php
// auto-generated by sfViewConfigHandler
// date: 2011/11/16 00:20:04
$response = $this->context->getResponse();


  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());



  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (null === $this->getDecoratorTemplate() && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'layout' ? false : 'layout'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);
  $response->addMeta('title', 'UnRamalaK beta 1.0', false, false);
  $response->addMeta('description', 'UnRamalaK beta 1.0', false, false);
  $response->addMeta('keywords', 'symfony, project, UnRamalaK', false, false);
  $response->addMeta('language', 'fr', false, false);
  $response->addMeta('robots', 'index, follow', false, false);

  $response->addStylesheet('main', '', array ());
  $response->addStylesheet('jquery-ui', '', array ());
  $response->addStylesheet('/unramalakPlugin/css/editor', '', array ());
  $response->addStylesheet('modules/accueil.css', '', array ());
  $response->addJavascript('jquery/jquery.min', '', array ());
  $response->addJavascript('jquery/jquery-ui.min', '', array ());
  $response->addJavascript('jquery/jquery.maskedinput.min', '', array ());
  $response->addJavascript('/unramalakPlugin/js/unramalak.js', '', array ());


