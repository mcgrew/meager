<?php

// This is where modules will be registered. 
// The format is $modules->register( 'name', 'path', 'options' );.
// Path  is relative to the '/modules/' directory.

$modules->register( 'STATUS_301', 'STATUS/301.php' );
$modules->register( 'STATUS_302', 'STATUS/302.php' );
$modules->register( 'STATUS_307', 'STATUS/307.php' );
$modules->register( 'STATUS_400', 'STATUS/400.php' );
$modules->register( 'STATUS_401', 'STATUS/401.php' );
$modules->register( 'STATUS_403', 'STATUS/403.php' );
$modules->register( 'STATUS_404', 'STATUS/404.php' );
$modules->register( 'STATUS_410', 'STATUS/410.php' );
$modules->register( 'STATUS_500', 'STATUS/500.php' );
$modules->register( 'STATUS_501', 'STATUS/501.php' );




$modules->register( 'main menu', 'menu.php', array(
	'id' => 'navigation',
	'menu' => array( 
		"Home" => "/",
		"Help" => array(
			"FAQ" => "FAQ.php"
		),
		"About ".$config[ 'sitename' ] => "about.php"
	),
));

$modules->register( 'search', 'search.php', array( 
			'moduleclass_sfx' => null,
			'containerId' => null,
			'focus_action' => 'clear_if_default',
			'default_value' => 'Search'
));

$modules->register( 'analytics', 'analytics.php', array(
			'tracker' => false 
));

$modules->register( 'mysqli', 'mysqli.php', array(
			'host' => ini_get( "mysqli.default_host" ),
			'username' => ini_get( "mysqli.default_user" ),
			'password' => ini_get( "mysqli.default_pw" ),
			'dbname' => "",
			'port' => ini_get( "mysqli.default_port" ),
			'socket' => ini_get( "mysqli.default_socket" )
));

$modules->register( 'ldap', 'ldap.php', array( 
			'host' => 'localhost',
			'port' => 389,
			'protocol_version' => 3,
			'base_dn' => 'dc=example,dc=org',
			'bind_rdn' => '',
			'bind_password' => '',
			'uid_field' => 'uid'
));

?>
