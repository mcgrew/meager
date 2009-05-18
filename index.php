<?


if ( !defined( '_VALID_' )) define( '_VALID_', true );

include( 'configuration.php' );
include( 'globals.php' );
include( 'modules.php' );

$modules->register( 'main_content',  '../'.current_page( ));

include ( 'templates/'.$config_template.'/index.php' );


?>
