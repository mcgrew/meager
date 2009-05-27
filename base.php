<?


if ( !defined( '_VALID_' )) define( '_VALID_', true );

include( 'globals.php' );
include( 'configuration.php' );
include( 'modules.php' );

$modules->register( 'content',  "../$current_page" );
if ( !file_exists( $current_page ))
	$modules->register( 'content', $modules->get_filename( 'STATUS_404' ));

ob_start( );
include ( 'templates/'.get_template( ).'/index.php' );
ob_flush( );

?>
