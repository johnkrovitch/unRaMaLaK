<?php

class menuComponents extends sfComponents
{
	public function executeShow()
	{
	  $items = sfConfig::get('app_menu', array());
    $menu = array();

    if(is_array($items)){
      $menu = $items;
    }
    $this->setVar('menu', $menu);
	}
}