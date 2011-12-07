<?php

class menuComponents extends sfComponents
{
	public function executeShow()
	{
    $menu_config_key = $this->getVar('menu');
	  $menu = sfConfig::get('app_menu_'.$menu_config_key, array());

    $this->setVar('menu', $menu);
    $this->setVar('menu_name', $menu_config_key);
    $this->setVar('current_route_name', $this->getContext()->getRouting()->getCurrentRouteName());
	}
}