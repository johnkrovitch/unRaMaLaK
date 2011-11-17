<?php

class MapForm extends sfForm
{
  public function configure()
  {    
    $this->widgetSchema->setNameFormat('map[%s]');
    
    // widgets
    $this->setWidget('name', new sfWidgetFormInput(array(), array('maxlength' => 100)));
    $this->setWidget('width', new sfWidgetFormInput(array(), array('maxlength' => 5)));    
    $this->setWidget('height', new sfWidgetFormInput(array(), array('maxlength' => 5)));    
    
    // validators
    $this->setValidator('name', new sfValidatorString(array('required' => true, 'max_length' => 100)));
    $this->setValidator('width', new sfValidatorString(array('required' => true, 'max_length' => 5)));
    $this->setValidator('height', new sfValidatorString(array('required' => true, 'max_length' => 5)));           
  } 
  
  public function save()
  {
    // TODO: faire des forls pour ça rame moins
    $datas = $this->getValues();
    
    // map
    $map = new Map();
    $map->setName($datas['name']);
    $map->setWidth($datas['width']);
    $map->setHeight($datas['height']);
    $map->save();
    
    // cells
    $cells = array();
    
    foreach(range(0, $datas['width'] - 1) as $x){
      foreach(range(0, $datas['height'] -1) as $y){
        $cell = new Cell();
        $cell->setPositionX($x);
        $cell->setPositionY($y);
        $cell->setIdMap($map->getId());
        $cell->save();
        // starting cell
        if($x == 0 && $y == 0){
          $map->setStartingCellId($cell->getId());
          $map->save();
        }
      }
    }    
  }
}