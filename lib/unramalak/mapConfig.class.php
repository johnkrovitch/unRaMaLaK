<?php

class mapConfig
{
  private $user_id;
  private $map_id;
  
  private $height;
  private $width;
  private $height_limit;
  private $width_limit;
  
  private $is_new = false;
  
  public static function getMapConfig($size, $user_id = null, $map_id = null)
  {
    $config = new self();
    
    if(!$user_id || !$map_id){
      $this->is_new = true;
    }
    $config->user_id = $user_id;
    $config->map_id = $map_id;   
    
    if($size){
      $config->setSize($size);
      
    }else{
      throw new sfException('La map n\'a pas de taille définie');
    }
    return $config;
  }
  
  private function __construct()
  {
  }

  public function getUserId()
  {
    return $this->user_id;
  }
  
  public function getMapId()
  {
    return $this->map_id;
  }  
  
  public function isNew()
  {
    return $this->is_new;
  }
  
  public function setSize($size, $delimiter = 'x')
  {
    if($size){
      $size_array = unramalakUtils::parseSize($size, $delimiter);
      $this->height = $size_array[0];
      $this->width = $size_array[1];
    }
  }
  
  public function setSizeLimit($size_limit, $delimiter = 'x')
  {
    if($size_limit){
      $size_array = unramalakUtils::parseWithDelimiter($size_limit, $delimiter);
      $this->height_limit = $size_array[0];
      $this->width_limit = $size_array[1];
    }
  }
  
  public function getHeight()
  {
    return $this->height;
  }
  
  public function getWidth()
  {
    return $this->width;
  }
  
  public function getHeightLimit()
  {
    return $this->height_limit;
  }
  
  public function getWidthLimit()
  {
    return $this->width_limit;
  }
}