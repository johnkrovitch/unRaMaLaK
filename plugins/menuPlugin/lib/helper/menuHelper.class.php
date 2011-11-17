<?php

class menuHelper
{
  protected $applicationRouting = null;
  protected static $_instance = null;
  
  public function getApplicationRouting($application, sfWebRequest $request, $controller = null)
  {
    if (!$this->applicationRouting)
    {
      if(!$controller){ // by default, controller has same name as application
        $controller = '/'.$application.'.php';
      }      
      $context = array('path_info' => $request->getPathInfo(), 
                       'prefix'    => $controller,
                       'method'    => $request->getMethod(),
                       'host'      => $request->getHost());      
      $this->applicationRouting = new sfPatternRouting(new sfEventDispatcher(), null, array('context' => $context));
  
      $config = new sfRoutingConfigHandler();
      $routes = $config->evaluate(array(sfConfig::get('sf_apps_dir').'/'.$application.'/config/routing.yml'));
  
      $this->applicationRouting->setRoutes($routes);
    }
    return $this->applicationRouting;
  }
  
  /**
  * Creates cross-application links
  */
  public function generateApplicationRoute($application, $controller = null, $request, $name, $parameters = array())
  {
    return $this->getApplicationRouting($application, $request, $controller)->generate(str_replace('@', '', $name), $parameters, true);
  }
  
  /**
   * @return menuHelper object
   */
  public static function getInstance()
  {
    if(!menuHelper::$_instance){
      menuHelper::$_instance = new self();
    }
    return menuHelper::$_instance;
  }
}