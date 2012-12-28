<?php

class mapUserContext
{
	private $user;
	private $heros;
	private $map_path;
	private $id_user;		

	private function __construct($user_id)
	{		
		$this->user = sfGuardUserTable::getInstance()->find($user_id);
		if(!isset($this->user)){
		  throw new sfException('Utilisateur introuvable');
		}		
	}

	public function getHeroes()
	{
		if($this->heros == null){
			$this->heros = Doctrine::getTable('Heros')->getByUser($this->id_user);
		}
		return $this->heros;
	}
	
	public function getMap()
	{		
		// le heros n'est pas encore cree
		if(count($this->heros) == 0){ 
			$id_race = sfContext::getInstance()->getUser()->getIdRace();
			$id_map = gameData::getStartMapId($id_race);	
		}else{ // le heros est deja cree
			$id_map = $this->getHeroes()->getFirst()->get('id_map', 1);
		}
		$map = Doctrine::getTable('Map')->find($id_map);		
		if(!$map){
			throw new Exception('La map n\'a pas pu être trouvé en base!');
		}
		return $map;
	}
}

