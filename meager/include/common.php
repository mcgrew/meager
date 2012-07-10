<?php
require_once( 'secure.php' );
global $mysqli;
$modules->load( 'mysqli' );

$modules->register( 'experiments', 'experiments.php', array( 
	'username' => @$_SESSION['username'],
	'projectid' => @$_SESSION['projectid']
));

$modules->register( 'files', 'files.php', array( 
	'projectid' => @$_SESSION['projctid'],
));

function status_text( $status ) {
	switch( $status ) {
		case 10:
			return 'Initialized';
		case 30:
			'In Progress';
		case 50:
			return 'Successful';
	}
}

if ( isset( $_REQUEST[ 'project' ])) {
	$query = 'SELECT EXPGRPID FROM EXPGROUP,USERS 
					WHERE 
						EXPGROUP.USERID=USERS.USERID AND
						EXPGROUP.NAME=? AND
						USERNAME=?';
	$statement = $mysqli->prepare( $query );
	$statement->bind_param( 'ss', $_REQUEST[ 'project' ], $_SESSION[ 'username' ]);
	$statement->execute( );
	$statement->bind_result( $projectid );
	if( $statement->fetch( ))
		$_SESSION[ 'projectid' ] = $projectid;
	$statement->free_result( );
}

$config[ 'data_root' ] = meager_config( "doc_root" ) . "/data/";


?>
