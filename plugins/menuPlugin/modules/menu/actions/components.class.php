<?php

class menuComponents extends sfComponents
{
	public function executeShow()
	{
	  $menu = sfConfig::get('app_menu');
	  $configured_menu = array();
	  
	  // if custom menu
	  if($config_key = $this->getVar('menu_config_key')){
	     $menu = sfConfig::get($config_key);
	  }		
		if(!$menu || count($menu) == 0){ // default route
		  $menu = array(array('link' => '@homepage', 'label' => __('Accueil')));
		}		
		// items treatment
		foreach($menu as $menu_item){
		  // cross-apps links
		  if(array_key_exists('application', $menu_item)){
		    
		    $controller = array_key_exists('controller', $menu_item) ? $menu_item['controller'] : null;
		    
		    $menu_item['link'] = menuHelper::getInstance()->generateApplicationRoute($menu_item['application'], $controller, $this->getRequest(), $menu_item['link']);
		    //die(print_r($menu_item['link']));
		  }
		  // selected item
		  //if()
		  $configured_menu[] = $menu_item;
		}
		$this->menu = $configured_menu;		
	}
}