<?php

class editorGamedata
{
  public static function getPointers()
  {
    return sfConfig::get('app_editor_pointers');
  }
}