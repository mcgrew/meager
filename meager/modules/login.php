<?php
/*
	Module
	======
		__Login__
			Creates a login dialog on the page. 

		Options
		-------
			auth_type : The type of authentication to use. Should be the name of a 
				registered authentication module (such as 'ldap_auth', etc.)
			redirect : The page to redirect to upon successful login.
*/
if (!( meager_config( 'allow_insecure_login' )  || isset( $_SERVER[ 'HTTPS' ]))) {
	die( "<h2>Log in over unencrypted http connection is not permitted.</h2>" );
}

if ( !isset( $_SESSION[ 'username' ])) {
	if ( isset( $_REQUEST[ 'username' ])) {
		$auth_type = $this->get_opt( 'auth_type' );
		error_log( "Loading authenticathion module $auth_type" );
		$modules->load( $auth_type );
	}
}
if ( !isset( $_SESSION[ 'username' ])) {
	echo "<div id='login_box'>";
	if ( isset( $_REQUEST['username']))
		echo "<span id='loginFail'>Login failed - please try again</span>";
	echo "<form name='loginForm' method='post' action='".meager_current_page( )."'>";
	echo "<div id='username_div'>";
	echo "	<label>Username: ";
	echo "		<input type='text' name='username' id='username_input' />";
	echo "	</label>";
	echo "</div>";
	echo "<div id='password_div'>";
	echo "	<label>Password: ";
	echo "		<input type='password' name='password' id='password_input' />";
	echo "	</label>";
	echo "</div>";
	echo "<input type='submit' value='login'>";
	echo "</form>";
	echo "</div>";
}

if ( isset( $_SESSION[ 'username' ]) && isset( $_REQUEST[ 'username' ]) &&
	   !strcmp( $_SESSION[ 'username' ], $_REQUEST[ 'username' ])) {
	if ( $this->get_opt( 'login_callback' )) {
		$callback = $this->get_opt( 'login_callback' );
		$callback( );
	}
	redirect( $this->get_opt( 'redirect' ));
}
?>
