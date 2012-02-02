<?php
/*
	Module
	=====
		__null_auth__
			Performs authentication with an ldap server based on a provided username
			and password (as $_POST variables)

		Options
		-------
			success : The page the user should be directed to upon a successful login.
*/
defined( '_VALID_' ) or die( 'Access Denied' );

if( isset($_REQUEST['username'])) {
	$_SESSION[ 'username' ] = $_POST[ 'username' ];
}

?> 
