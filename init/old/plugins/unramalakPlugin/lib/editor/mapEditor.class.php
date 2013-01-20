<?php

// TODO unramalak: à supprimer

class mapEditor
{
	private $map;
	private $map_types_cells_family;
	private $pointers;
	
	public function __construct($map_id)
	{
	  $cell_types_families = CellTypeFamilyTable::getInstance()->findAll();;
	  $map = MapTable::getInstance()->find($map_id);
	  
	  $this->map = $this->throwUnless($map);
	  $this->map_types_cells_family = $this->throwUnless($cell_types_families);
	  $this->pointers = editorGamedata::getPointers();
	}
	
	public function render()
	{
	  $limit = unramalakUtils::parseWithDelimiter(sfConfig::get('app_editor_map_size'));
	  $starting_point = $this->getMap()->getStartingCell()->getPoint();
	  $ending_point = $this->getMap()->getEndingCell($starting_point, $limit)->getPoint();
	  
	  $render = '<div id="map">';	  
	  $render.= $this->getMap()->render($starting_point, $ending_point);
	  $render.= '</div>';

	  return $render;
	}
	
	public function renderMenu()
	{
	  $content = $this->renderCellTypeMenu();
	  $content.= $this->renderPointerMenu();
	  
	  return $content;
	}
	
	/**
	 * @return Map
	 */
	public function getMap()
	{
	  return $this->map;
	}
	
	private function renderCellTypeMenu()
	{
	  $content = '<div id="editor-menu">';
	  $content.= '<div id="cell-family-container">';

	  foreach($this->map_types_cells_family as $cell_family){ // Cells type families
	    $content.= '<ul class="cell-family">';
	     
	    foreach($cell_family->getCellType() as $cell_type){ // Cells types
	      $content.= '<li class="cell-type">';
	      $content.= image_tag($cell_type->getBackgroundImage(), array('alt' => $cell_type->getName(), 'class' => 'item'));
	      $content.= '</li>';
	    }
	    $content.= '</ul>';
	  }
	  $content.= '</div>';
	  $content.= '</div>';
	  
	  return $content;
	}
	
	private function renderPointerMenu()
	{
	  $content = '<div id="editor-pointer-menu"><ul>';
	  
	  foreach($this->pointers as $pointer){
	    $content.= '<li><a>'.$pointer['label'].'</a>';
      $content.= '<input type="hidden" class="pointer-size-value" value="'.$pointer['size'].'" /></li>';
	  }
	  $content .= '</ul></div>';
	  
	  return $content;
	}
	
	private function throwUnless($object)
	{
	  if(!$object){
	    throw new sfException(sprintf('Erreur lors du chargement de l\'objet %s : %s dans l\'éditeur', va, $object));
	  }
	  if($object instanceof Doctrine_Collection && count($object) == 0){
	    throw new sfException(sprintf('Erreur lors du chargement de l\'objet %s : %s dans l\'éditeur', $$object, $object));	    
	  }
	  return $object;
	}
}