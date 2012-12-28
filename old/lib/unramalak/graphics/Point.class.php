<?php

class Point
{
	private $x = 0;
	private $y = 0;

	public function __construct($x, $y)
	{
		$this->x = (int)$x;
		$this->y = (int)$y;
	}
	
	public function getX()
	{
		return $this->x;		
	}
	
	public function getY()
	{
		return $this->y;
	}
}