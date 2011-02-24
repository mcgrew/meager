<?php

defined( '_VALID_' ) or die( 'Access denied' );
if ( isset( $_SESSION[ 'username' ]))
	redirect( "/" );
echo "<h1>Please Log in</h1>";
$modules->load( 'login' );

?>
