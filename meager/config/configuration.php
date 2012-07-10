<?php

defined( '_VALID_' ) or die( "Access Denied" );

// This array should contain various configurations for your web site.
$config = array( 
	'language' => 'en',
	'template' => 'default',
	'sitename' => 'Meager',
	'title' => 'Default Web Site',
	'site_owner' => 'Site Owner',
	'cache_dir' => '/tmp/meager/cache/',
	'allow_insecure_login' => true,
	'module_dir' => '/meager/modules/'
);

if ( !file_exists( $config[ 'cache_dir' ]))
	mkdir( $config[ 'cache_dir' ], 0777, true );

// This array should contain a list of valid index files for a directory.
$config[ 'index_files' ] = array(
	"index.php",
	"index.html"
);

// This is an associative array, and special templates are defined as follows:
// template_name => ( condition );
// If the condition is true when a page is loaded, that template will be used.
// The first which evaluates to true will be used.
// If none are true, the template $config[ 'template' ] will be used.
$special_templates = array( 
	'null' =>  
    preg_match( '/^services\/.*/' , meager_current_page( ));
	,
);

?>
