<?php

/*

Class: Module
	This class is not intended to be instantiated directly, but instead will be
	instantiated by a ModuleHandler object when a module is registered.

Syntax:
	(start code)
	new Module( );
	(end)

Example:
	(start code)
	$modules = new ModuleHandler( );
	$modules->register( 'test', 'test.php', array( 'option1' => 'yes' ));
	$test = $modules->get( 'test' );
	(end)

*/
Class Module
{
	private $options = array( );
	private $file;
	function __construct( $file, $options = array( ))
	{
		$this->file = $file;
		$this->set_opts( $options );
	}

	/*

		Method: load
			Print out the output of a module.

	*/
	function load( )
	{
		global $modules;
		global $config;
		$mod = $this;
		include( $_SERVER[ 'DOCUMENT_ROOT' ].'modules/'.$this->file );
	}

	/*

		Method: to_string
			Retrive the output of a module.

		Returns:
			A string containing the output of a module.

	*/
	function to_string( )
	{
		ob_start( );
		$this->load( );
		$returnvalue = ob_get_contents( );
		ob_end_clean( );
		return $returnvalue;
	}

	/*

		Method: set_opts
			Set options for a module

		Arguments:
			options - An associative array containing the options to be set.

		Returns:
			True if the module exists, false otherwise.

	*/
	function set_opts( $options )
	{
		$this->options = array_merge( $this->options, $options );
	}

	/*

		Method: set_opt
			Set a single option for a module.

		Arguments:
			name - A string containing the name of the option to be set.
			value - The value for the option.

	*/
	function set_opt( $name, $value )
	{
		$this->setOpts( array( $name => $value ));
	}

	/*

		Method: get_opts
			Get the options for a module.

		Returns:
			An associative array containing the options for the module.

	*/
	function get_opts( )
	{
		return $this->options;
	}

	/*

		Method: get_opt
			Get the value for an option

		Arguments:
			name - A string containing the name of the option.
			default - A default value to use if the option is not set.

		Returns:
			The value of the option if it is set, or the value of $default if 
			it is not.

	*/
	function get_opt( $name, $default=null )
	{
		if ( isset( $this->options[ $name ]) && $this->options[ $name ] !== null )
			return $this->options[ $name ];
		return $default;
	}
	
	/*

		Method: get_filename
			Get the filename registered for a module

		Returns:
			A string containing the filename for the module.

	*/
	function get_filename( )
	{
		return $this->file;
	}
}

/*

Class: ModuleHandler

Syntax:
	(start code)
	new ModuleHandler( );
	(end)

Example:
	(start code)
	$modules = new ModuleHandler( );
	$modules->register( 'test', 'test.php', array( 'option1' => 'yes' ));
	(end)

*/
Class ModuleHandler
{
	private $registry = array( );
	function __construct( )	
	{
	}

	/*
		Method: register
			Register a module for later use.

		Arguments:
			name - A string containing the name for the module.
			file - A string containing the php filename for the module
			options (optional) - An associative array containing any options which the 
				module might require.
	*/
	function register( $name, $file, $options=array( ))
	{
		$this->registry[ $name ] = new Module( $file );
		$this->set_opts( $name, $options );
	}

	/*

		Method: exists
			Determine whether a module has been registered.

		Arguments: 
			name - A string containing the name for the module.

		Returns:
			True if the module exists, false otherwise.

	*/
	function exists( $name )
	{
		return isset( $this->registry[ $name ]);
	}

	/*

		Method: get
			Get a module object that has been registered.

		Arguments: 
			name - A string containing the name for the module.

		Returns:
			The module object requested.

	*/
	function get( $name )
	{
		if ( $this->exists( $name ))
			return $this->registry[ $name ];
		return false;
	}
	
	/*

		Method: load
			Print out the output of a module.

		Arguments: 
			name - A string containing the name for the module.

	*/
	function load( $name )
	{
		if ( $this->exists( $name ))
		{
			$this->get( $name )->load( );
			return true;
		}
		error_log( current_page( ).": The module '$name' is not registered" );
		return false;
	}

	/*

		Method: to_string
			Retrieve the output of a module as a string.

		Arguments:
			name - A string containing the name for the module.

		Returns:
			A string containing the output of the module.

	*/
	function to_string( $name )
	{
		if ( $this->exists( $name ))
		{
			return $this->get( $name )->to_string( );
		}
	}

	/*

		Method: set_opts
			Set options for a module.

		Arguments:
			name - A string containing the name for the module.
			options - An associative array containing the options to be set.

		Returns:
			True if the module exists, false otherwise.

	*/
	function set_opts( $name, $options )
	{
		if ( $this->exists( $name ))
		{
			$this->get( $name )->set_opts( $options );
			return true;
		}
	}
	
	/*

		Method: set_opt
			Set a single option for a module.

		Arguments:
			name - A string containing the name for the module.
			opt_name - A string containing the name of the option to be set.
			opt_value - The value for the option.

		Returns:
			True if the module exists, false otherwise.

	*/
	function set_opt( $name, $opt_name, $opt_value )
	{
		if ( $this->exists( $name ))
		{
			$this->get( $name )->set_opt( $opt_name, $opt_value );
			return true;
		}
		return false;
	}

	/*

		Method: get_opt
			Get the value for an option

		Arguments:
			name - A string containing the name for the module.
			opt_name - A string containing the name of the option.
			default - A default value for the option to be returned if one is not set.

		Returns:
			The option value for the module if it exists, false otherwise.

	*/
	function get_opt( $name, $opt_name, $default=null )
	{
		if ( $this->exists( $name ))
		{
			return $this->get( $name )->get_opt( $opt_name, $default );
		}
		return false;
	}

	/*

		Method: get_opts
			Get the options for a module.

		Arguments:
			name - A string containing the name for the module.

		Returns:
			An associative array containing the options for the module.

	*/
	function get_opts( $name )
	{
		if ( $this->exists( $name ))
		{
			return $this->get( $name )->get_opts( );
		}
		return false;
	}

	/*

		Method: get_filename
			Get the filename registered for a module

		Arguments:
			name - A string containing the name for the module.

		Returns:
			A string containing the filename for the module.

	*/
	function get_filename( $name )
	{
		if ( $this->exists( $name ))
		{
			return $this->get( $name )->get_filename( );
			return false;
		}

	}
}

$modules = new ModuleHandler( );

/*

	Function: current_page
		Get the filename of the page to be displayed.

	Returns:
		A string containing the filename.

*/
function current_page( )
{
	$current_page = @$_REQUEST[ 'page' ];
	if ( !file_exists( $current_page ))
	{
		if ( file_exists( $_SERVER[ 'DOCUMENT_ROOT' ].$current_page.".php" )) $current_page .= '.php';
		if ( file_exists( $_SERVER[ 'DOCUMENT_ROOT' ].$current_page.".html" )) $current_page .= '.html';
	}
	else if ( is_dir( $_SERVER[ 'DOCUMENT_ROOT' ].$current_page ))
		$current_page = find_index_for_dir( $current_page );
	return $current_page;
}
$current_page = current_page( );

/*

	Function: find_index_for_dif
		Internal function which will return the index file for a directory passed in.

*/
function find_index_for_dir( $dir )
{
	foreach ( $config_index_files as $file )
	{
		if ( file_exists( $_SERVER[ 'DOCUMENT_ROOT' ].$dir.'/'.$file ) && !is_dir( $_SERVER[ 'DOCUMENT_ROOT' ].$dir.'/'.$file ))
			return $dir.'/'.$file;
	}
	return false;
}

/*

	Function: get_template
		Get the template to be used. This can be overridden with the 'template' GET or POST variable

	Returns:
		The directory name for the template to be used.

*/
function get_template( )
{
	global $special_templates;
	global $config;
	if ( isset( $_REQUEST[ 'template' ] ) and is_dir( 'templates/'.($template = str_replace( '/', '', $_REQUEST[ 'template' ]))))
		return $template;
	foreach( $special_templates as $template => $active )
		if ( $active )
			return $template;
	return $config[ 'template' ];
}
?>
