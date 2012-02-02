<?php
/*
	Module
	======
		__Menu__
			Creates a mysql connection. The connection is stored in a global variable
			with the name of this modulei($GLOBALS[ $this->name ])

		Options
		-------
			host : The host name of the mysql server. Defaults to the php ini setting.
			username : The username for the mysql login. Defaults to the php ini 
				setting.
			password : The password for the mysql login. Defaults to the php ini
				setting.
			dbname : The database name to initially select. Defaults to nothing.
			port : The port to use for the connection. Defaults to the php ini setting.
			socket : The mysql socket to use for connection. Defaults to the php ini
				setting.
*/

defined( '_VALID_' ) or die( 'Access Denied' );

if ( !isset( $GLOBALS[ $this->name ])) {

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
}

?>
