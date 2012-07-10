<?php

defined( '_VALID_' ) or die( 'Access Denied' );

$config[ 'salt' ] = '7OmsXn2d4MglaqovA5VuzE1JvPhU4jXJFQ_g_6v1wPwaQzXI4mnBQEj0Efio.oSy';

$modules->register( 'ldap_auth', 'ldap_auth.php', array( 
			'host' => '',
			'port' => 389,
			'protocol_version' => 3,
			'base_dn' => '',
			'bind_rdn' => '',
			'bind_password' => '',
			'uid_field' => 'samaccountname',
));

$modules->get( 'analytics' )->set_opt( 'tracker', "UA-16063341-1" );

$modules->get( 'mysqli' )->set_opt( 'username', 'root' );
$modules->get( 'mysqli' )->set_opt( 'password', null );
$modules->get( 'mysqli' )->set_opt( 'dbname', 'pipeline' );


?>
