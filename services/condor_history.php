<?php

header( "Content-Type: application/json" );

if ( isset($_REQUEST['count'])){
  echo condor_history( (int)$_REQUEST['count'] );
} else {
  echo condor_history( );
}

?>
