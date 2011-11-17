<?php

class myUser extends sfGuardSecurityUser
{
	public function hasRace()
	{
		return $this->getProfile()->getRace();	
	}
	
	public function getNbPlayedDays()
	{
	  // TODO faire cete fonction
	  return 10;
	}
	
	/*public function getIdUser()
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
	}*/
}
