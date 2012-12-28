<?php

/**
 * connexion actions.
 *
 * @package    unramalak
 * @subpackage connexion
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class connexionActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		if($this->getRequestParameter('disconnect') == true){
			$this->getUser()->setAuthenticated(false);
			$this->getUser()->disconnect();	
		}					
	}
	
	public function executeLogin()
	{
		$login = $this->getRequestParameter('login');
		$password = $this->getRequestParameter('password');
		
		if ($this->getRequest()->getMethod() == sfRequest::POST && $login != '' && $password != '' && 
		$this->getUser()->authenticate($login, $password)){
			$this->redirect('editor/index');			
		}else{
			echo 'pas de bol !!!';
		}
	}
}
