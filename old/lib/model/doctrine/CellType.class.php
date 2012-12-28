<?php

/**
 * CellType
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    unramalak
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class CellType extends BaseCellType
{
  public function getBackgroundImage()
  {
    $background_image = $this->_get('background_image');
    
    if(!$background_image){
      $background_image = 'default.png';
    }
    return $background_image;
  }
}