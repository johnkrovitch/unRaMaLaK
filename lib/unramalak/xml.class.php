<?php

// TODO améliorer le parser xml
class Xml
{
	public static function parse($file = null)
	{
		if(file_exists($file)){
			return simplexml_load_file($file);
		}else{
			return null;
		}
	}
	
	/**
	 * Retourne un chemin corrige : .xml ajoute si besoin, slash,antislash corrige
	 * @param $filename
	 * @return unknown_type
	 */
	public static function checkXml($filename = '')
	{
		if(substr($filename, 0, strlen($filename) - 3) != '.xml'){
			$filename .= '.xml';
		}
		$filename = str_replace('//', '/', $filename);
		$filename = str_replace('\\\\', '\\', $filename); // ....		
		return $filename;
	}
}

?>