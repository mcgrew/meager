<?php

// This array should contain various configurations for your web site.
$config = array( 
	'language' => 'en',
	'template' => 'default',
	'sitename' => 'Web Site',
	'title' => 'Default Web Site',
	'site_owner' => 'Site Owner'
);

// This array should contain a list of valid index files for a directory.
$config_index_files = array( 
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
		preg_match( '/^info.php$/' , $current_page)
	,
);

?>
