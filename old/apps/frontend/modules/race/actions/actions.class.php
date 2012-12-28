<?php

/**
 * race actions.
 *
 * @package    unramalak
 * @subpackage race
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class raceActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{		
		if($this->getUser()->hasRace()){
			$this->getUser()->setIdRace($this->getRequestParameter('race'));			
			$this->forward('accueil','index');
		}	
	}	
	
	public function executeSave($request)
	{
		if($request->getMethod() != sfRequest::POST){			
			$this->redirect('accueil/index');
		}		
		$this->getUser()->setIdRace($this->getRequestParameter('race'));			
		$this->forward('accueil','index');		
	}
}
