<?php

$modules->load( 'ldap' );

if ( isset( $_SESSION[ 'username' ]))
	echo "Hello " . $_SESSION[ 'username' ];
else
	echo "Sorry, who are you again?";

?>
