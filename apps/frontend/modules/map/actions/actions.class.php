<?php

/**
 * map actions.
 *
 * @package    unramalak
 * @subpackage map
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mapActions extends sfActions
{
	/**
	 * Display all maps
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
	  $this->maps = MapTable::getInstance()->findAll();
	}

	public function executeNew(sfWebRequest $request)
	{
	  $this->form = new MapForm();
	  
	  if($request->getMethod() == sfWebRequest::POST){
	    $this->form->bind($request->getParameter('map'));
	    
	    if($this->form->isValid()){
	      $this->form->save();
	      $this->redirect('@map');
	    }
	  }
	}
	
	public function executeDelete(sfWebRequest $request)
	{
	  $map = MapTable::getInstance()->find($request->getParameter('id'));
	  $this->forward404Unless($map);

	  $map->delete();
	  $this->redirect('@map');
	}
	
	public function executeEdit(sfWebRequest $request)
	{
	  $this->editor = new mapEditor($request->getParameter('id'));
	}
}