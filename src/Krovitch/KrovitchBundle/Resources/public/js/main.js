/**
 * Retourne true si l'objet est null ou undefined
 * @param object
 * @return bool
 */
$.isNull = function(object){
  return typeof object === 'undefined' || object === null || object.length === 0;
};

/**
 * Retourne true si l'objet n'est pas null ou undefined
 * @param object
 * @return bool
 */
$.isNotNull = function(object){
  return !$.isNull(object);
};