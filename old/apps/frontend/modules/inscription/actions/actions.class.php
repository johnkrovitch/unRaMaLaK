<?php

/**
 * inscription actions.
 *
 * @package    unramalak
 * @subpackage inscription
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class inscriptionActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		if(!$this->user)
			$this->user = new User();
	}
	
	public function executeSubscribe($request)
	{
		parent::validateMethod();
		
		$user = new User();
		$user->setName($this->getRequestParameter('name'));
		$user->setLogin($this->getRequestParameter('login'));
		$user->setPassword($this->getRequestParameter('password'));
		$user->setEmail($this->getRequestParameter('email'));		
		$user->setIdRights(sfConfig::get('app_rights_normal'));
		$user->setEnabled(true);				
		$user->save();
	}
}
