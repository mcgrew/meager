<?php

function condor_info( $command ) {
  exec( $command, $output, $exitStatus );
  $doc = new DOMDocument( );
  $doc->loadXML( implode( $output ));
  $jobs = $doc->getElementsByTagName( "c" );


  $returnvalue = "{ \"jobs\": [";
  for( $i=0; $i < $jobs->length; $i++ ) {
    if ( $i )
      $returnvalue .= ",";
    $returnvalue .= "{";
    $attributes = $jobs->item( $i )->getElementsByTagName( "a" );
    for ( $j=0; $j < $attributes->length; $j++ ) {
      if ( $j )
        $returnvalue .= ",";
      $name = $attributes->item( $j )->attributes->getNamedItem( "n" )->textContent;
      $value = str_replace( "\"", "\\\"", $attributes->item( $j )->textContent );
      // put quotes around the value only if it is non-numeric.
      if ( is_numeric( $value ))
        $returnvalue .= "\"$name\": $value";
      else
        $returnvalue .= "\"$name\": \"$value\"";
    }
    $returnvalue .= "}";

  }
  $returnvalue .= "]}";
  return $returnvalue;
}

function condor_q( ) {
  return condor_info( "condor_q -xml" );
}

function condor_history( $count=0 ) {
  // the -match operator produces bad xml in condor <= 7.8.1. Should be fixed in
  // the 7.8.2 is release. If you are running 7.8.2, remove this and uncomment
  // the following 3 lines.
//  if ($count) {
//    return condor_info("condor_history -xml -match $count");
//  }
  return condor_info("condor_history -xml");
}

?>
