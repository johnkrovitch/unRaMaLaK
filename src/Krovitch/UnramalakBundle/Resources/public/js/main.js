/**
 * Return true if object is undefined or null or object.length equals 0
 * @param object
 * @return bool
 */
$.isNull = function(object){
  return typeof object === 'undefined' || object === null || object.length === 0;
};

/**
 * Return false if object is undefined or null or object.length equals 0
 * @param object
 * @return bool
 */
$.isNotNull = function(object){
  return !$.isNull(object);
};