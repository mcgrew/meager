<?php

// This is where modules will be registered. 
// The format is $modules->register( 'name', 'path', 'options' );.
// Path  is relative to the '/modules/' directory.

$modules->register( 'STATUS_301', 'status/301.php' );
$modules->register( 'STATUS_302', 'status/302.php' );
$modules->register( 'STATUS_307', 'status/307.php' );
$modules->register( 'STATUS_400', 'status/400.php' );
$modules->register( 'STATUS_401', 'status/401.php' );
$modules->register( 'STATUS_403', 'status/403.php' );
$modules->register( 'STATUS_404', 'status/404.php' );
$modules->register( 'STATUS_410', 'status/410.php' );
$modules->register( 'STATUS_500', 'status/500.php' );
$modules->register( 'STATUS_501', 'status/501.php' );




$modules->register( 'main menu', 'menu.php', array(
	'id' => 'navigation',
	'menu' => array( 
		"Home" => "/",
		"Help" => array(
			"FAQ" => "FAQ.php"
		),
		"About".$config[ 'sitename' ] => "aboutus.html"
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

?>
