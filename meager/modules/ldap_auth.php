<?php
/*
	Module
	=====
		__LDAP__
			Performs authentication with an ldap server based on a provided username
			and password (as $_POST variables)

		Options
		-------
			host : The host name of the ldap server. Defaults to 'localhost'
			port : The port nubmer for the ldap server. Defaults to 389
			base_dn : The basedn of the user database (e.g. 'dc=example,dc=org')
			bind_rdn : The rdn used to bind anonmously to the ldap server
			bind_password : The password used to bind anonymously to the ldap server
			uid_field : The ldap field which contains the user id. Normally 'uid' for 
				openldap, 'samaccountname' for Microsoft Active Directory. Defaults to
				'uid'
			success : The page the user should be directed to upon a successful login.
*/
error_log( "Attempting ldap authentication..." );

if( isset($_POST['username']) && 
	  isset($_POST['password']) && 
		!isset($_SESSION[ 'username' ])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	error_log("Authenticating $username...");
	$ds = ldap_connect( $this->get_opt( 'host', 'localhost' ),
	                    $this->get_opt( 'port', 389 ));
	ldap_set_option( $ds, LDAP_OPT_PROTOCOL_VERSION, 3 );
	
	//Can't connect to LDAP.
	if( !$ds ) {
		error_log( "Error in contacting the LDAP server!");
	} else {
		
		//Connection made -- bind anonymously and get dn for username.
		$bind = ldap_bind($ds,
		                  $this->get_opt( 'bind_rdn', null ),
		                  $this->get_opt( 'bind_password', null ));
		
		//Check to make sure we're bound.
		if( !$bind ) {
				error_log( "Anonymous bind to LDAP FAILED!" );
		} else {
			
			//look for the user in the ldap database
			$search = ldap_search($ds, $this->get_opt( 'base_dn' ), 
			                      $this->get_opt( 'uid_field', 'uid' ) ."=$username");
			
			//Make sure only ONE result was returned
			// if not, they might've thrown a * into the username.  Bad user!
			if( ldap_count_entries($ds,$search) == 1 ) {
			
				$info = ldap_get_entries($ds, $search);
				
				//Now, try to rebind with their full dn and password.
				$bind = ldap_bind($ds, $info[0]["dn"], $password);
				if( $bind ) {
				
					//Now verify the previous search using their credentials.
					$search = ldap_search($ds, $this->get_opt( 'base_dn' ),
					                      $this->get_opt( 'uid_field', 'uid' ) ."=$username");
					
					$info = ldap_get_entries($ds, $search);
					if( $username == $info[0][ $this->get_opt( 'uid_field', 'uid' )][0] ) {
							error_log( "Authenticated $username." );
							$_SESSION['username'] = $username;
							$_SESSION['fullname'] = $info[0]['cn'][0];
					}
					ldap_close($ds);
				}
			}
		}
	}
}
?> 
