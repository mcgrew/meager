<?php
/*

This module requires the php xsl module to be installed. Use as follows:


$modules->register( 'xslTest', 'xslt.php', array( 
	"xml" => "test.xml",
	"xsl" => "test.xsl",
	"params" => array(
		
	)
));

$modules->load( 'xslTest' );

xml/xsl path names should be relative to the web root.

*/
if ( !file_exists( $config[ 'cache_dir' ].'/xslt/' ))
	mkdir( $config[ 'cache_dir' ].'/xslt/', 0777, true );

if (preg_match( "/^http:\/\//",  $this->get_opt( 'xml' ))) {
	$cache_time = $this->get_opt( "cache_time", "1 day" );
	
	$cacheFileName = $config[ 'cache_dir' ].'/xslt/'.md5( $this->get_opt( 'xml' )).".xml";
	
	if ( !file_exists( $cacheFileName ) || strtotime( "-".$cache_time ) > filectime( $cacheFileName )) {
	        $service = fopen( $this->get_opt( 'xml' ), 'r' );
	        $cacheFile = fopen( $cacheFileName, 'w' );
	        while( $output = fread( $service, 8192 ) ) {
	                fwrite( $cacheFile, $output );
	        }
	        fclose( $cacheFile );
	}
	$this->set_opt( 'xml', $cacheFileName );
}

// Load the XML source
$xml = new DOMDocument;
$xml->load( $this->get_opt( 'xml' ));

$xsl = new DOMDocument;
$xsl->load($this->get_opt('xsl'));

// Configure the transformer
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl); // attach the xsl rules

$proc->setParameter( '', $this->get_opt( 'params', array()));

echo html_entity_decode($proc->transformToXML($xml));

?>

