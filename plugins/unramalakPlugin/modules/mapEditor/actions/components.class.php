<?php

class mapEditorComponents extends sfComponents
{
  protected $map_options = array();
  protected $menu_options = array();
  
  public function executeShow(sfWebRequest $request)
  {
    $map_id = $this->getVar('map_id');

    if(!$map_id){
      throw new sfException('Vous devez passer en paramètre un map_id au composant map_editor');
    }
    $map = MapTable::getInstance()->find($map_id);

    if(!$map){
      throw new sfException('La map est introuvable');
    }
    $menu_options = array();
    $map_options = array();
    $cache_size = sfConfig::get('app_editor_map_editor_cache_size');
    $starting_cell = CellTable::getInstance()->find($map->getStartingCellId());
    list($x, $y) = unramalakUtils::parseWithDelimiter(sfConfig::get('app_editor_map_size'));

    // center starting point if possible
    $starting_x =  unramalakMathUtils::positiveOrZero($starting_cell->getPositionX() - intval($x/2) - $cache_size);
    $starting_y = unramalakMathUtils::positiveOrZero($starting_cell->getPositionY() - intval($y/2) - $cache_size);

    // get ending point
    $ending_x = $starting_cell->getPositionX() + intval($x/2) + $cache_size;
    $ending_y = $starting_cell->getPositionY() + intval($y/2) + $cache_size;
    $cells = CellTable::getInstance()->getCellsBetweenPosition($map_id, new Point($starting_x, $starting_y), new Point($ending_x, $ending_y));

    // init menu
    $menu_options['cell_types_families'] = Cell_Type_FamilyTable::getInstance()->getFamiliesWithCellType();
    $menu_options['pointers'] = sfConfig::get('app_editor_pointers');

    // init map
    $map_options['map'] = $map;
    $map_options['cells'] = $cells;

    // sort cells for display
    $map_options['cells'] = unramalakUtils::sortInTable($map_options['cells']);

    // set vars for the view
    $this->setVar('map_options', $map_options);
    $this->setVar('menu_options', $menu_options);
  }
}