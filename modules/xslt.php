<?php
/*

This module requires the php xsl module to be installed. Use as follows:


$modules->register( 'xslTest', 'xslt.php', array( 
	"xml" => "test.xml",
	"xsl" => "test.xsl"
));

$modules->load( 'xslTest' );

xml/xsl path names should be relative to the web root.

*/

// Load the XML source
$xml = new DOMDocument;
$xml->load( $this->get_opt( 'xml' ));



$xsl = new DOMDocument;
$xsl->load($this->get_opt('xsl'));

// Configure the transformer
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl); // attach the xsl rules

echo html_entity_decode($proc->transformToXML($xml));

?>

