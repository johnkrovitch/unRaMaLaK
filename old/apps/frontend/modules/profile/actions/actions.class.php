<?php

/**
 * profile actions.
 *
 * @package    unramalak
 * @subpackage profile
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class profileActions extends sfActions
{
	public function executeNew(sfWebRequest $request)
	{
	  $this->form = new PlayerForm();
	  
	  if($request->getMethod() == sfWebRequest::POST){
	    $this->form->bind($request->getParameter('Player'));
	    
	    if($this->form->isValid()){
	      $this->form->save();	      
	      $this->redirect('@homepage');
	    }
	  }
	}
}
