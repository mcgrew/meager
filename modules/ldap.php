<?php

if( isset($_REQUEST['login']) && isset($_REQUEST['password']) ) {
    //LDAP stuff here.
    $username = trim($_REQUEST['login']);
    $password = trim($_REQUEST['password']);

    error_log("Authenticating...");
    $ds = ldap_connect( $this->get_opt( 'host', 'localhost' ));
    
    //Can't connect to LDAP.
    if( !$ds ) {
        error_log( "Error in contacting the LDAP server!");
        exit;
    }
    
    //Connection made -- bind anonymously and get dn for username.
    $bind = ldap_bind($ds);
    
    //Check to make sure we're bound.
    if( !$bind ) {
				error_log( "Anonymous bind to LDAP FAILED!" );
        exit;
    }
    
    $search = ldap_search($ds, $this->get_opt( 'base_dn' ), "uid=$username");
    
    //Make sure only ONE result was returned
		// if not, they might've thrown a * into the username.  Bad user!
    if( ldap_count_entries($ds,$search) != 1 ) {
        error_log( "Error processing username -- please try to login again." );
//        redirect( $_SERVER[ 'DOCUMENT_ROOT' ] . "/login.php");
        exit;
    }
    
    $info = ldap_get_entries($ds, $search);
    
    //Now, try to rebind with their full dn and password.
    $bind = @ldap_bind($ds, $info[0][dn], $password);
    if( !$bind || !isset($bind)) {
        echo "Login failed -- please try again.";
//        redirect( $_SERVER[ 'DOCUMENT_ROOT' ] . "/login.php");
        exit;
    }
    
    //Now verify the previous search using their credentials.
    $search = ldap_search($ds, $this->get_opt( 'base_dn' ), "uid=$username");
        
    $info = ldap_get_entries($ds, $search);
    if( $username == $info[0][uid][0] ) {
        echo "Authenticated.";
        $_SESSION['username'] = $username;
        $_SESSION['fullname'] = $info[0][cn][0];
//        redirect( $_SERVER[ 'DOCUMENT_ROOT' ] . "/index.php");
        exit;
    } else {
        echo "Login problems -- please try again.";
//        redirect( $_SERVER[ 'DOCUMENT_ROOT' ] . "/login.php");
        exit;
    }
    ldap_close($ds);
    exit;
}
?> 
