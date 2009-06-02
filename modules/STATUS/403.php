
<?php

header( 'HTTP/1.0 403 Forbidden' );
echo "<h1>Forbidden</h1>";
echo "<p>You do not have proper authorization to view ".current_page( ).".</p>";
echo "<p><a href='/'>Back to ".$config[ 'sitename' ]." home</p>";


?>
