<?php

namespace Krovitch\KrovitchBundle\Utils;

class StringUtils
{
  /**
   * Return class name separated from namespace
   * @static
   * @param $class_name string, Full class name (with namespace)
   * @param bool $with_namespace Return an array containing class name and namespace instead of class name (array['namespace'], array['classname'])
   * @return array|string
   */
  static function getClassNameFromNamespace($class_name, $with_namespace = false)
  {
    $class = join('', array_slice(explode('\\', $class_name), -1));

    if($with_namespace){
      $class = array('namespace' => array_slice(explode('\\', $class_name), 0, -1),
                     'classname' => $class);
    }
    return $class;
  }

  static function getEntityClassName($object, $toLower = true)
  {
    $class_name = StringUtils::getClassNameFromNamespace(get_class($object));
    $excludes = array('controller', 'manager');

    if ($toLower) {
      $class_name = strtolower($class_name);
    }
    return str_replace($excludes, '', $class_name);
  }
}