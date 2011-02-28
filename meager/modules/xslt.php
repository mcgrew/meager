<?php
/*
	Module
	=====
		__XSLT__
			Transforms an xml file based on an xslt file. This module requires the php
			xsl module to be installed.

	Options
	-------
		xml : The XML file to read from. Can be a remote file.
		xsl : The XSL file to use in the transformation.
		params : An array of key-value  parameters to be passed to the XSLT.
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

