<?php

class unramalakMathUtils
{
  public static function positiveOrZero($number)
  {
    if($number < 0){
      $number = 0;
    }
    return $number;
  }
}