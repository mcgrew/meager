<?php


if ( !defined( '_VALID_' )) define( '_VALID_', true );
session_start( );

require_once( 'globals.php' );
require_once( 'config/configuration.php' );
require_once( 'config/modules.php' );
if ( is_readable( 'config/secure.php' ))
	require_once( 'config/secure.php' );

// Register any modules/options contained in these variables.
if ( isset( $module_list ))
	foreach( $module_list as $name => $file )
		$modules->register( $name, $file );
		
if ( isset( $module_options ))
	foreach( $module_options as $name => $opts )
			$modules->set_opts( $name, $opts );

$modules->register( 'content',  "../$mgrCurrent_page" );
if ( !file_exists( $mgrCurrent_page ))
	$modules->register( 'content', $modules->get_filename( 'STATUS_404' ));

ob_start( );
include ( 'templates/'.mgrGet_template( ).'/index.php' );
ob_end_flush( );

?>
