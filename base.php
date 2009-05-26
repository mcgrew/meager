<?


if ( !defined( '_VALID_' )) define( '_VALID_', true );

include( 'globals.php' );
include( 'configuration.php' );
include( 'modules.php' );

$modules->register( 'content',  "../$current_page" );

include ( 'templates/'.get_template( ).'/index.php' );


?>
