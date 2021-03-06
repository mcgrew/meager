<?php

if ( !defined( '_VALID_' )) define( '_VALID_', true );
session_start( );

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
	private $name;

	function __construct( $name, $file, $options = array( )) {
		global $config;
		if ( substr( $file, 0, 1 ) == "/" )
			$this->file = $file;
		else
			$this->file = meager_config( 'doc_root' ).meager_config( 'module_dir' ).$file;
		$this->name = $name;
		$this->set_opts( $options );
	}

	/*

		Method: load
			Print out the output of a module.

	*/
	function load( ) {
		global $modules;
		global $config;
		$mod = $this;
		$params = $this; // Joomla module compatibility.
		include( $this->file );
	}

	/*

		Method: to_string
			Retrive the output of a module.

		Returns:
			A string containing the output of a module.

	*/
	function to_string( ) {
		ob_start( );
		$this->load( );
		$returnvalue = ob_get_clean( );
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
	function set_opts( $options ) {
		$this->options = array_merge( $this->options, $options );
	}

	/*

		Method: set_opt
			Set a single option for a module.

		Arguments:
			name - A string containing the name of the option to be set.
			value - The value for the option.

	*/
	function set_opt( $name, $value ) {
		$this->set_opts( array( $name => $value ));
	}

	/*

		Method: get_opts
			Get the options for a module.

		Returns:
			An associative array containing the options for the module.

	*/
	function get_opts( ) {
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
	function get_opt( $name, $default=null ) {
		if ( isset( $this->options[ $name ]) && $this->options[ $name ] !== null )
			return $this->options[ $name ];
		return $default;
	}

	/*
		Method: get
			Get the value for an option (Joomla module compatibility)

		Arguments:
			name - A string containing the name of the option.
			default - A default value to use if the option is not set.

		Returns:
			The value of the option if it is set, or the value of $default if 
			it is not.
	*/
	function get( $name, $default=null ) {
		return $this->get_opt( $name, $default );
	}
	
	/*
		Method: get_filename
			Get the filename registered for a module

		Returns:
			A string containing the filename for the module.
	*/
	function get_filename( ) {
		return $this->file;
	}

	/*
		Method: get_name
			Get the name registered for a module

		Returns:
			A string containing the name for the module.
	*/
	function get_name( ) {
		return $this->name;
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
	function __construct( )	{ }

	/*
		Method: register
			Register a module for later use.

		Arguments:
			name - A string containing the name for the module.
			file - A string containing the php filename for the module
			options (optional) - An associative array containing any options which the 
				module might require.
	*/
	function register( $name, $file, $options=array( )) {
		$module = new Module( $name, $file );
		$module->set_opts( $options );
		$this->registry[ $name ] = $module;
		return $module;
	}

	/*

		Method: exists
			Determine whether a module has been registered.

		Arguments: 
			name - A string containing the name for the module.

		Returns:
			True if the module exists, false otherwise.

	*/
	function exists( $name ) {
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
	function get( $name ) {
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
	function load( $name ) {
		if ( $this->exists( $name )) {
			$this->get( $name )->load( );
			return true;
		}
		error_log( meager_current_page( ).": The module '$name' is not registered" );
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
	function to_string( $name ) {
		if ( $this->exists( $name )) {
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
	function set_opts( $name, $options ) {
		if ( $this->exists( $name )) {
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
	function set_opt( $name, $opt_name, $opt_value ) {
		if ( $this->exists( $name )) {
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
	function get_opt( $name, $opt_name, $default=null ) {
		if ( $this->exists( $name )) {
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
	function get_opts( $name ) {
		if ( $this->exists( $name )) {
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
	function get_filename( $name ) {
		if ( $this->exists( $name )) {
			return $this->get( $name )->get_filename( );
			return false;
		}

	}
}

$modules = new ModuleHandler( );

/* 
	Function: meager_config
		Gets a configuration setting from the $config array
*/
function meager_config( $name, $default=null ) {
	global $config;
	if ( isset( $config[ $name ]))
		return $config[ $name ];
	return $default;
}

/*
	Function: meager_current_page
		Get the filename of the page to be displayed.

	Returns:
		A string containing the filename.

*/
function meager_current_page( ) {
	$meager_current_page = @$_REQUEST[ 'page' ];
	if ( !file_exists( $meager_current_page )) {
		if ( file_exists( meager_config( 'doc_root' ).$meager_current_page.".php" )) $meager_current_page .= '.php';
		if ( file_exists( meager_config( 'doc_root' ).$meager_current_page.".html" )) $meager_current_page .= '.html';
	} else if ( is_dir( meager_config( 'doc_root' ).$meager_current_page ))
		$meager_current_page = meager_find_index_for_dir( $meager_current_page );
	return $meager_current_page;
}

/*

	Function: meager_find_index_for_dir
		Internal function which will return the index file for a directory passed in.

*/
function meager_find_index_for_dir( $dir ) {
	foreach ( meager_config( 'index_files' ) as $file ) {
		if ( file_exists( meager_config( 'doc_root' ).$dir.'/'.$file ) && !is_dir( meager_config( 'doc_root' ).$dir.'/'.$file ))
			return $dir.'/'.$file;
	}
	return false;
}

/*

	Function: meager_get_template
		Get the template to be used. This can be overridden with the 'template' GET or POST variable

	Returns:
		The directory name for the template to be used.

*/
function meager_get_template( ) {
	global $special_templates;
	global $config;
	if ( isset( $_REQUEST[ 'template' ] ) and is_dir( 'meager/templates/'.($template = str_replace( '/', '', $_REQUEST[ 'template' ]))))
		return $_REQUEST[ 'template' ];
	foreach( $special_templates as $template => $active )
		if ( $active )
			return $template;
	return $config[ 'template' ];
}

/*
	Function: redirect
		Sends redirect header to the browser, or embeds a javascript redirect if
		headers have already been sent.
*/
function redirect( $location ) {
	if( $location ) {
		if ( headers_sent( )) {
			echo "<script type='text/javascript'>";
			echo "window.location=\"$location\"";
			echo "</script>";
		} else {
			header( "Location: http://". meager_config('http_host') . $location, true, 307 );
		}
	}
}



/*
	Function: print_array
		A debug function - prints an array in a human readable format.
*/
function print_array($array)
{
        echo "<div style=\"font-family: 'Courier New', Courier, monospace; font-size: 12px;\">\n";
        print_array_recursive($array, '');
        echo "</div>\n";
}

function print_array_recursive($array, $prefix)
{
        foreach ($array as $k=>$v)
        {
                if (is_array($v))
                {
                        echo $prefix.$k.' =&gt; '."<br>\n";
                        print_array_recursive($v, $prefix."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
                }
                else
                {
                        echo $prefix.$k.' =&gt; '.$v."<br>\n";
                }
        }
}

/**
 * A function for safely including a file based on user input.
 * 
 * @param $file The file name to be sanitized.
 */
function meager_safe_include( $file ) {
	include( "./" . str_replace( '../', '', $file ));
}


ob_start( );

require_once( 'meager/config/configuration.php' );
$meager_current_page = meager_current_page( );

// figure out the http host name (or set this manually if something fails)
$config[ 'http_host' ] = isset($_SERVER['HTTP_X_FORWARDED_HOST']) ?
   $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST'];
// set the root directory for meager.
$config[ 'http_root' ] = dirname( $_SERVER[ "SCRIPT_NAME" ]);
$config[ 'doc_root' ] = $_SERVER[ 'DOCUMENT_ROOT' ].$config[ 'http_root' ].'/';

require_once( 'meager/config/modules.php' );
foreach ( glob( "meager/include/*.php" ) as $file ) {
	require_once( $file );
}


// Register any modules/options contained in these variables.
if ( isset( $module_list ))
	foreach( $module_list as $name => $file )
		$modules->register( $name, $file );
		
if ( isset( $module_options ))
	foreach( $module_options as $name => $opts )
			$modules->set_opts( $name, $opts );

$modules->register( 'content',  $config[ 'doc_root' ] ."/". $meager_current_page );
if ( !file_exists( $meager_current_page ))
	$modules->register( 'content', $modules->get_filename( 'STATUS_404' ));

include( 'meager/templates/'.meager_get_template( ).'/index.php' );

// tidy up the html if the null template isn't being used and $config[ 'tidy' ] is true
if ( meager_config( 'tidy', false ) && meager_get_template( ) != 'null' ) {
	$tidy = tidy_parse_string( ob_get_clean( ));
	$tidy->cleanRepair( );
	echo tidy_get_output( $tidy );
} else {
	ob_end_flush( );
}

?>
