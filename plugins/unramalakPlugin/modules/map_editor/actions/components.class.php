<?php

class map_editorComponents extends sfComponents
{
  protected $map_options = array();
  protected $menu_options = array();
  
  public function executeShow(sfWebRequest $request)
  {
    $menu_options = array();
    $map_options = array();
    $map_id = $this->getVar('map_id');
    $limit = unramalakUtils::parseWithDelimiter(sfConfig::get('app_editor_map_size'));

    if(!$map_id){
      throw new sfException('Vous devez passer en paramètre un map_id au composant map_editor');
    }
    // init menu
    $menu_options['cell_types_families'] = Cell_Type_FamilyTable::getInstance()->findAll();
    $menu_options['pointers'] = sfConfig::get('app_editor_pointers');
	  $map_options['map'] = MapTable::getInstance()->find($map_id);

    // init map
    $limit = unramalakUtils::parseWithDelimiter(sfConfig::get('app_editor_map_size'));
	  $map_options['starting_point'] = $map_options['map']->getStartingCell()->getPoint();
	  $map_options['ending_point'] = $map_options['map']->getEndingCell($map_options['starting_point'], $limit)->getPoint();
    $map_options['cells'] = CellTable::getInstance()->getCellsBetweenPosition($map_id, $map_options['starting_point'], $map_options['ending_point']);

    // sort cells for display
    $map_options['cells'] = unramalakUtils::sortInTable($map_options['cells']);

    // set vars for the view
    $this->setVar('map_options', $map_options);
    $this->setVar('menu_options', $menu_options);
  }
}