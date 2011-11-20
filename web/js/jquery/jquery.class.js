/*! 
* Simple Class and SubClass handler ( optional for jquery plugin )
* 
* Copyright (c) 2011, Meng Soon 
* Licensed under MIT
* http://mengsoon.wordpress.com/license
*
* version: 0.3.4
*
* Known Issues:
* - IE toString method will be native any how
*
* TODO:
* - Check for this.hasOwnProperty( method ) in the method utility
*
*/
( function( window, undefined ) {
	
	//get jQuery from window if it exist
	var $ = window.jQuery ? window.jQuery : {};
	
	//use jquery each or an alternative
	$.each = $.each || function( object, callback ) {
		//loop each items in object
		for ( var index in object ) {
			//call callback function
			callback.call( object, index, object[ index ] );
		}
	}
	
	//use jquery extend or an alternative. jquery before 1.0.4, $.extend is not reliable 
	$.extend = ( $.extend && !( ( /^1\.0\..*$/.test( $.fn.jquery ) ) || ( /^\$.*\$$/.test( $.fn.jquery ) ) ) ? $.extend : undefined ) || function( deep, target ) {
		var objects;
		
		if ( Object.prototype.toString.call( deep ) != '[object Boolean]' ) {
			//bind false to deep and recall function if first parameter is not boolean
			return arguments.callee.apply( this, [ false ].concat( Array.prototype.slice.call( arguments ) ) );
		} else if ( !( ( objects = Array.prototype.slice.call( arguments, 2 ) ).length ) ) {
			//bind $ to target, bind target to third parameter and recall function if no third parameter exist
			return arguments.callee.call( this, deep, $, target );
		}
		
		//loop for each parameters start from 3rd
		$.each( objects, function( index, object ) {
			//loop each properties
			$.each( object, function( index, value ) {
				//replace value
				target[ index ] = typeof value == 'object' && deep ? arguments.callee.call( this, deep, target[ index ], value ) : value;
			} );
		} );
		
		//return updated target
		return target;
	}
	
	//extend jquery utility
	$.extend( {
		//use jquery isFunction or an alternative
		isFunction : $.isFunction || function( fn ) {
			return Object.prototype.toString.call( fn ) == '[object Function]';
		},
		
		//use jquery isArray or an alternative
		isArray: $.isArray || function( array ) {
			return Object.prototype.toString.call( array ) == '[object Array]';
		}
	} );
	
	//main function
	var jClass = ( function() {
		
		return function( structure, Parent ) {
			//default parent to Object if not pass in
			Parent = Parent || Object;
			
			//set each method's _super to call parent's method
			$.each( structure, function( index, method ) {
				//filter by function
				if ( $.isFunction( method ) ) {
					//set the method's _super to call the parent's method
					//ensure always call the latest version of the parent method
					method._super = function() {
						//get the method
						var fn = Parent.prototype[ index ];
						
						//call and return the method
						//return the _super object if not a function, or probably 'undefined'
						return $.isFunction( fn ) ? fn.apply( this, arguments ) : fn;
					}
				}
			} );
			
			//generate a class
			function Class() {
				//prevent buggy problem when calling Class function without 'new' 
				if ( !( this instanceof arguments.callee ) ) {
					//return a instantiate object of the class
					return arguments.callee.apply( new arguments.callee, arguments );
				}
				
				//execute only if init present and it is a function
				if ( $.isFunction( this.init ) ) {
					//call init function with pass in parameters
					this.init.apply( this, arguments );
				}
				
				//return the scope, important to have for the case mistake calling class without the 'new' keyword
				return this;
			}
			
			//inherit from parent
			Class.prototype = new Parent;
			
			//extend Class.prototype to override methods and properties
			$.extend( Class.prototype, structure, {
				
				//override constructor
				constructor: Class,
				
				//create a general _super to call parent's method
				//use parent's _super if exist, prevent redundant
				_super: Class.prototype._super || function() {
					//get the method's _super function created above
					var fn = arguments.callee.caller._super;
					
					//call and return the method
					//return the _super object if not a function, or probably 'undefined'
					return $.isFunction( fn ) ? fn.apply( this, arguments ) : fn;
				}
				
			} );
			
			//basic things done here. begins for extra things
			
			//extebd class object, add additional utilities
			$.extend( Class, {
				
				//make this class extandable
				extend: ( function( fn ) {
					//return a new function with binded parent class 
					return function( structure ) {
						//execute the function with current class as parent
						return fn.call( this, structure, Class );
					};
				//pass in the main function
				} )( arguments.callee ),
				
				//allow to modify method without losing the ability to call _super 
				method: function( method, fn, overload ) {
				
					( function( c ) {
					
						//check is method exist and overload is true
						if ( method in c && overload === true ) {
							//overload method
							Class.overload( method, fn );
						} else {
							//set the _super, if existing method exist, use the existing _super instead
							fn._super = $.isFunction( c[ method ] ) ? c[ method ]._super : function() {
								//get the method
								var fn = Parent.prototype[ method ];
								
								//call and return the method
								//return the _super object if not a function, or probably 'undefined'
								return $.isFunction( fn ) ? fn.apply( this, arguments ) : fn;
							};
							
							//override method
							c[ method ] = fn;
						}
						
					} )( Class.prototype );
				},
				
				//allow the class overload methods
				//NOTE: only able to overload with different numbers of parameter
				overload: function( method, fn ) {
					//cache original method
					var old = Class.prototype[ method ];
					
					//set the new method _super
					fn._super = old && old._super;
					
					//replace and return new method
					return Class.prototype[ method ] = function() {
					
						//call matched method and return result
						return fn.length == arguments.length ?
						
							//call new function if parameters length match
							fn.apply( this, arguments ) :
							//check is original method is a function, prevent error
							$.isFunction( old ) ?
							
								//call original method
								old.apply( this, arguments ) :
								//return old if not match
								old;
					};
				},
				
				//multiple overload
				overloads: function( methods ) {
					//go through each methods
					for ( var method in methods ) {
						//list of functions
						var fns = methods[ method ];
						
						//convert to array if it is not array
						fns = $.isArray( fns ) ? fns : [ fns ];
						
						//overload method with each fn
						$.each( fns, function( index, fn ) {
							Class.overload( method, fn );
						} );
					}
				},
				
				//allow the class implement interfaces
				//extend a class with another class or object
				implement: function() {
					//get all pass in arguments
					var interfaces = Array.prototype.slice.apply( arguments );
					
					//process each interface
					$.each( interfaces, function( index, object ) {
						//make sure is not undefined
						if ( object !== undefined ) {
							//create new object is it is a class
							object = object.prototype ? new object() : object;
							
							//extend class's prototype
							$.extend( Class.prototype, object, {
								//prevent constructor and _super to be overrided
								constructor: Class.prototype.constructor,
								_super: Class.prototype._super
							} );
						}
					} );
				}
				
			} );
			
			//return the class function
			return Class;
		}
	} )();
	
	//provide public access
	if ( window.jQuery ) {
		//extend to jquery library if exist
		$.extend( { 
			jClass: jClass
		} );
	} else {
		//or else set Class to a global Class
		window.jClass = jClass;
	}
	
} )( window );