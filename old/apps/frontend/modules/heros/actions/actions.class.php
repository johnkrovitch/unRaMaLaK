<?php

/**
 * heros actions.
 *
 * @package    unramalak
 * @subpackage heros
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class herosActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->avatars = gameData::getAvatars();
		$this->bannieres = gameData::getBannieres();
		$this->trees = Label::getCompetencesTrees();
		$this->stats = Label::getStats();
	}
	
	public function executeSave(sfWebRequest $request)
	{
		// TODO Unramalak : blackListValidator pour le nom 
		$avatar_id = $request->getParameter('avatar_id', 0);
		$heros_name = $request->getParameter('heros_name', 0);
		$heros_tree = $request->getParameter('heros_tree', 0);		
		$hidden1 = $request->getParameter('hidden1', 0);
		$hidden2 = $request->getParameter('hidden2', 0);
		$hidden3 = $request->getParameter('hidden3', 0);
		$id_user = $this->getUser()->getAttribute('id_user', 0);
		
		$conn = Doctrine::getConnectionByTableName('heros');
		$conn->beginTransaction();
		
		try{
			$heros = new Heros($id_user);
			$heros->set('id_user', $id_user);
			$heros->set('name', $heros_name);
			$heros->set('level', 1);
			$heros->set('xp', 0);
			$heros->set('xp_next_level', gameData::getHerosXpNextLevel());
			$heros->set('id_user', $id_user);
			
			// recuperation de l'id de la map en fonction de la race			
			$map = new mapClass($id_user);
			$map_infos = $map->getMapInfos();			
			// chargement de la position de depart du heros
			$heros->set('position_x', $map_infos->getHerosStartPosition()->getX());
			$heros->set('position_y', $map_infos->getHerosStartPosition()->getY());
			$heros->set('id_map', 1);			
			
			// Stuff du heros
			$stuff = gameData::getStartStuff($heros_tree);
			$heros->set('id_stuff', $stuff->get('id'));						
			$heros->save();
			
			// Attributs du heros
			$attr = new Attributes();
			$attr->set('strength', $hidden1);
			$attr->set('agility', $hidden2);
			$attr->set('intelligence', $hidden3);
			$attr->set('id_heros', $heros->get('id'));			
			$attr->set('life', gamedata::getStartHerosLifePoints($heros_tree));
			$attr->set('life_max', gamedata::getStartHerosLifePoints($heros_tree));
			$attr->set('mana', gamedata::getStartHerosManaPoints($heros_tree));
			$attr->set('mana_max', gamedata::getStartHerosManaPoints($heros_tree));
			$attr->set('limit_lvl', gamedata::getStartLimitLevel());
			$attr->set('limit_max', gamedata::getStartLimitLevel());
			$attr->save();			
			
			$this->getUserBase()->set('has_heros', true);			
			$this->getUserBase()->save();
			$conn->commit();
		}catch(Exception $e){
			$conn->rollback();
			$this->forward('error', 'index');
		}
		$this->forward('accueil', 'index');
	}
	
	public function executeEdit(sfWebRequest $request)
	{
		
	}
}
