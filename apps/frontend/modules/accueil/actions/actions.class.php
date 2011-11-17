<?php

/**
 * accueil actions.
 *
 * @package    unramalak
 * @subpackage accueil
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class accueilActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		// si l'utilisateur n'a pas de race, on le redirige		
		if(!$this->getUser()->hasRace()){
			$this->redirect('race/index');
		}
	}
}
