<?php

Class Module
{
	private $options = array( );
	private $file;
	function __construct( $file, $options = array( ))
	{
		$this->file = $file;
		$this->set_opts( $options );
	}
	function load( )
	{
		global $modules;
		global $config;
		$mod = $this;
		include( $_SERVER[ 'DOCUMENT_ROOT' ].'modules/'.$this->file );
	}

	function to_string( )
	{
		ob_start( );
		$this->load( );
		$returnvalue = ob_get_contents( );
		ob_end_clean( );
		return $returnvalue;
	}

	function set_opts( $options )
	{
		$this->options = array_merge( $this->options, $options );
	}

	function set_opt( $name, $value )
	{
		$this->setOpts( array( $name => $value ));
	}

	function get_opts( )
	{
		return $this->options;
	}

	function get_opt( $name, $default=null )
	{
		if ( isset( $this->options[ $name ]) && $this->options[ $name ] !== null )
			return $this->options[ $name ];
		return $default;
	}
	function get_filename( )
	{
		return $this->file;
	}
}
Class ModuleHandler
{
	private $registry = array( );
	function __construct( )	
	{
	}

	function register( $name, $file, $options=array( ))
	{
		$this->registry[ $name ] = new Module( $file );
		$this->set_opts( $name, $options );
	}

	function exists( $name )
	{
		return isset( $this->registry[ $name ]);
	}

	function get( $name )
	{
		if ( $this->exists( $name ))
			return $this->registry[ $name ];
		return false;
	}
	
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

	function to_string( $name )
	{
		if ( $this->exists( $name ))
		{
			return $this->get( $name )->to_string( );
		}
	}

	function set_opts( $name, $options )
	{
		if ( $this->exists( $name ))
		{
			$this->get( $name )->set_opts( $options );
			return true;
		}
	}
	
	function set_opt( $name, $opt_name, $opt_value )
	{
		if ( $this->exists( $name ))
		{
			$this->get( $name )->set_opt( $opt_name, $opt_value );
			return true;
		}
		return false;
	}

	function get_opt( $name, $opt_name )
	{
		if ( $this->exists( $name ))
		{
			return $this->get( $name )->get_opt( $opt_name );
			return false;
		}
	}

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

function find_index_for_dir( $dir )
{
	foreach ( $config_index_files as $file )
	{
		if ( file_exists( $_SERVER[ 'DOCUMENT_ROOT' ].$dir.'/'.$file ) && !is_dir( $_SERVER[ 'DOCUMENT_ROOT' ].$dir.'/'.$file ))
			return $dir.'/'.$file;
	}
	return false;
}

function get_template( )
{
	global $special_templates;
	global $config;
	foreach( $special_templates as $template => $active )
		if ( $active )
			return $template;
	return $config[ 'template' ];
}
?>
