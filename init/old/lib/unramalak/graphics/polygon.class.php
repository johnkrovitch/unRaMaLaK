<?php

class polygon
{
	private $start_position;
	private $coordinates;
	
	public function __construct($x0 = 0, $y0 = 0) 
	{
		$x = (int)$x0;
		$y = (int)$y0;		
		$line_size = sfConfig::get('app_map_polygon_line_size', 0);		
		$this->coordinates = array(new coordinates($x, $y));
		
		// _
		$x = $x + $line_size;		
		$this->addCoordonates($x, $y);
		//    \
		$x = $x + $line_size;
		$y = $y - $line_size;		
		$this->addCoordonates($x, $y);		
		//    /
		$y = $y - $line_size;
		$x = $x - $line_size;		
		$this->addCoordonates($x, $y);
		//  _
		$x = $x - $line_size;
		$this->addCoordonates($x, $y);
		// \
		$x = $x + $line_size;
		$y = $y - $line_size;
		$this->addCoordonates($x, $y);
		// /
		$x = $x + $line_size;
		$y = $y + $line_size;
		$this->addCoordonates($x, $y);
		
		/*  __
		 * /  \		
		 * \__/    ;=) 
		 */		
	}
	
	public function addCoordonates($x, $y)
	{
		$this->coordinates[] = new coordinates($x, $y);
	}
}

?>