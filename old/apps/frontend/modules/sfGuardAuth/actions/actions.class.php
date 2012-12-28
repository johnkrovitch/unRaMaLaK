<?php

require_once(sfConfig::get('sf_plugins_dir').'/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php');

/**
 * sfGuardAuth actions.
 *
 * @package    unramalak
 * @subpackage sfGuardAuth
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardAuthActions extends BasesfGuardAuthActions
{
  public function executeLightSignin(sfWebRequest $request)
  {
    $user = $this->getUser();

    if($request->isXmlHttpRequest()){

      if ($user->isAuthenticated()){
        echo ajaxHeader::$signinFailureAlreadyLogged;
        return sfView::NONE;
      }
      $ajax_return = ajaxHeader::$signinFailure;
      $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');

      $this->form = new $class();
      $this->form->bind($request->getParameter('signin'));
      $this->form->disableLocalCSRFProtection();
      unset($this->form['remember']);

      if ($this->form->isValid()){
        $values = $this->form->getValues();
        $this->getUser()->signin($values['user'], false);

        die('lol');

        $ajax_return = ajaxHeader::$signinSuccess;
      }
      echo $ajax_return;
      return sfView::NONE;
    }else{
      return $this->redirect('@homepage');
    }
  }
}