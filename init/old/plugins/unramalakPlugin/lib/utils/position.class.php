<?php

class position
{
	private $_x = 0;
	private $_y = 0;
	
	public function __construct($x = 0, $y = 0)
	{
		$this->_x = $x;
		$this->_y = $y;
	}
	
	public function getX()
	{
		return $this->_x;
	}
	
	public function getY()
	{
		return $this->_y;	
	}
}

?>