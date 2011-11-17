<?php

class cell
{
	private $background = '';
	private $x;
	private $y;
	
	public function __construct($x, $y, $background = null)
	{
		$this->x = (int)$x;
		$this->y = (int)$y;
		$this->background = (string)$background;
		$this->path = sfConfig::get('app_map_images_path').$this->getBackground();		
	}
	
	public function getBackground()
	{
		return $this->background;
	}
	
	public function getX()
	{
		return $this->x;
	}
	
	public function getY()
	{
		return $this->y;
	}
	
	public function render()
	{		
		$content = '<div class="cell">';
		$content.= image_tag($this->path);
		$content.= '</div>';
		
		return $content;
	}
	
	public static function getCellsArray($size)
	{
	  $cells = array();
	  $width = $size['width'];
	  $height = $size['height'];

	  for($x = 0; $x < $width; $x++){
	    $cells[$x] = array();
	    for($y = 0; $y < $height; $y++){
	      $cells[$x][$y] = new self($x, $y);
	    }
	  }
	  //print_r($cells);
	  return $cells;
	}
}

