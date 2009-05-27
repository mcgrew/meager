<?php

header( 'HTTP/1.0 404 Not Found' );
echo "<h1>Not Found</h1>";
echo "<p>The requested URL ".current_page( )." was not found on this server.</p>";
echo "<p><a href='.'>Back to ".$config[ 'sitename' ]." home</p>";


?>
