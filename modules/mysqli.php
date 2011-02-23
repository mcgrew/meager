<?php



/*

Module
======
	__Menu__
		Creates a mysql connection. The connection is stored in a global variable
		with the name of this modulei($GLOBALS[ $this->name ])

*/

defined( '_VALID_' ) or die( 'Access Denied' );


$GLOBALS[ $this->name ] = new mysqli( 
	$this->get_opt( 'host', ini_get( "mysqli.default_host" )),
	$this->get_opt( 'username', ini_get( "mysqli.default_user" )),
	$this->get_opt( 'password', ini_get( "mysqli.default_pw" )),
	$this->get_opt( 'dbname', "" ),
	$this->get_opt( 'port', ini_get( "mysqli.default_port" )),
	$this->get_opt( 'socket', ini_get( "mysqli.default_socket" )));

if ( mysqli_connect_errno( )) {
	error_log( "MySQL connection failed: %s<br>", mysqli_connect_error( ));
}

?>
