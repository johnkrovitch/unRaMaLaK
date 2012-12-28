<?php

class myUser extends sfBasicSecurityUser
{
	public function authenticate($login, $password)
	{
		$user = Doctrine::getTable('User')->getByLoginPassword($login, $password);		
		if($user){
			//$this->getUserbase()->setLogged(true);
			$parameters = array('id_user'=>$user->get('id'), 'id_race'=>$user->get('id_race'));
			$this->loadSessionData($parameters);
			$this->setAuthenticated(true);
			$this->setCulture('fr_FR');
			return true;	
		}else{
			return false;
		}
	}
	
	/**
	 * Retourne l'Utilisateur courant de la base de données
	 * @return User
	 */
	public function getUserBase()
	{
		return $user = Doctrine::getTable('User')->find($this->getAttribute('id_user'));
	}
	
	/**
	 * Retourne true si l'utilsateur a deja une race
	 * @return unknown_type
	 */
	public function hasRace()
	{
		$user = $this->getUserBase();		
		if($user && $user->getRace())
			return true;
		else
			return false;	
	}
	
	public function getIdUser()
	{
		return $this->getAttribute('id_user', 0);	
	}
	
	public function getIdRace()
	{
		return $this->getAttribute('id_race', 0);
	}
	
	public function setIdRace($id_race)
	{	
		$user = $this->getUserBase();	
		$user->setIdRace($id_race);		
		$user->save();		
	}
	
	public function disconnect()
	{
		$this->setAuthenticated(false);		
	}

	public function loadSessionData($datas = array())
	{			
		foreach($datas as $name=>$data){			
			$this->setAttribute($name, $data);
			print_r($this->attributeHolders);			
		}		
	}
}
