<?php
class unramalakUtils
{
  public static function parseWithDelimiter($parse_value, $delimiter = 'x')
  {
    $parse_value_array = explode($delimiter, $parse_value);
    $return_array = null;  
    
    if(count($parse_value_array == 2)){
      $return_array = array($parse_value_array[0], $parse_value_array[1]);
    }
    return $return_array;
  }

  public static function sortInTable($flat_array, $row_method = 'getPositionX')
  {
    $rows = array();
    $columns = array();

    foreach($flat_array as $item){

      if(!isset($rows[$item->$row_method()])){
        $rows[$item->$row_method()] = array();
      }
      $rows[$item->$row_method()][] = $item;
    }
    return $rows;
  }
}