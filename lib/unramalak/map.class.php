<?php

/**
 * Représente un objet map
 * @author afrezet
 */
class unramalakMap
{	
	private $user_context;
	private $id_map;
	private $cells;
	private $heros;
	private $map_infos;
	
	private $xml;
	private $is_generated;
	private $is_new;
	private $xml_map;
	private $config;
	private $map;

	/**
	 * Constructeur de map. Initalise le contextUser, le xml et l'objet en base selon la configuration
	 * @param mapConfig $map_config
	 * @throws sfException
	 */
	public function __construct(mapConfig $map_config)
	{
	  $this->config = $map_config;
	  	  
	  if(!$this->getConfig()->isNew()){
	      
	    
	  }else{
  	  // contexte de l'utilisateur : heros, armée, équipement...
  		$this->user_context = mapUserContext::getUserContext($user_id);
  		if(!$this->user_context){
  		  throw new sfException(sprintf('Impossible de charger le contexte utilisateur "%" depuis la base', $user_id));
  		}
  		
  		$this->map = MapTable::getInstance()->find($map_id);
  		if(!$this->map){
  		  throw new sfException(sprintf('Impossible de charger la map "%s" depuis la base', $map_id));
  		}
  		// chargement du fichier xml
  		//$xml_path = sfConfig::get('app_map_absolute_path');
  		//$this->xml_map = $this->loadXml($xml_path);
  		//$this->cells = $this->map->getCells();
	  }		
		// initialisation
		//$this->cells = cell::getCellsArray($this->getConfig()->getSize());
		
	}
	
	public function render($start_point)
	{
	  die('lol');
	  $render = array();
	  $map_container = '';
	  $last_y = 0;
	  $cells = $this->getCells();
	  
	  //print_r($this->getCells());
	  
	  for($x = 0; $x < $this->getWidth(); $x++){	    
	    for($y = 0; $y < $this->getHeight(); $y++){
	      $render[] = $cells[$x][$y]->render();
	    }
	    $render[] = $this->getEndLine();
	  }
	  return implode('', $render);
	}
	
	/**
	 * Retourne true si la map est nouvelle, c'est-à-dire qu'elle ne correspond pas à un objet en base
	 * @return boolean
	 */
	public function isNew()
	{
	  return $this->is_new;
	}

	/**
	 * Retourne des informations partielles de la map	 
	 * @return mapInfos
	 */
	public function getMapInfos()
	{
		if(!$this->map_infos){
			$this->createMapInfos();
		}										
		return $this->map_infos;
	}
	
	public function getCells($starting_point = '0,0')
	{
	  if(!$this->cells){
	    $this->cells = $this->map->getCells();
	  }
	  
	  
	  return $this->cells;
	}
	
	/**
	 * Retourne la configuration de la map
	 * @return mapConfig
	 */
	public function getConfig()
	{
	  return $this->config;
	}
	
	public function getHeight()
	{
	  return $this->getConfig()->getHeight();
	}
	
  public function getWidth()
	{
	  return $this->getConfig()->getWidth();
	}
	
	private function createMapInfos()
	{
		$map = $this->loadXml();
		$this->map_infos = new mapInfos();		
		$this->map_infos->setHerosStartPosition((int)$map->heros_start->x, (int)$map->heros_start->y);	
	}

	private function loadXml($xml_path)
	{
	  if(!file_exists($xml_path)){
	    throw new sfException(sprintf('Impossible de charger le fichier xml "%s" de la map', $xml_path));
	  }	  
	  $simple_xml = simplexml_load_file($xml_path);
	  
	  //die($simple_xml);
	  	  
	  // check xml file validity
	  if(($errors = $this->checkXml($simple_xml)) !== true){
	    throw new sfException('Le xml de la map n\'est pas valide : '.implode(',', $errors));
	  }
	  //print_r($simple_xml);
	  
		
	}
	
	private function checkXml($xml)
	{
	  $is_valid = true;
	  $errors = array();
	  
	  if(!$this->xml->cell){
	    $is_valid = false;
	    $errors[] = 'zone "cells" invalide';
	  }
	  if(!$this->heros){
	    $is_valid = false;
	    $errors[] = 'zone "heros" invalide';
	  }	  
	  return $is_valid ? true : $errors;
	}
	
	private function getEndLine()
	{
	  return '<div class="floatbreaker"></div>';
	}
}
