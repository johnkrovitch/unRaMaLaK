<?php

class mapInfos
{
	private $_herosStartXPosition = 0;
	private $_herosStartYPosition = 0;
	
	public function getHerosStartPosition()
	{
		return new position($this->_herosStartXPosition, $this->_herosStartYPosition);
	}
	
	public function setHerosStartPosition($x = 0, $y = 0)
	{
		$this->_herosStartXPosition = $x;
		$this->_herosStartYPosition = $y;
	}
}

?>