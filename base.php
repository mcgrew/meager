<?


if ( !defined( '_VALID_' )) define( '_VALID_', true );

include( 'configuration.php' );
include( 'globals.php' );
include( 'modules.php' );

$modules->register( 'content',  '../'.current_page( ));

include ( 'templates/'.$config[ 'template'].'/index.php' );


?>
