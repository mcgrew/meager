/** Common javascript functions for EcoliHub
 * @author: Thomas McGrew
 * @date:   July 29, 2008
 *
 * @modified_by:
 * @modified_date:
 */


// These three variables control the actions of displayWarning( ), and displayInfo( )
SHOWWARNING = true;
SHOWINFO = true;
DEBUGLEVEL = 0;

/** This will display a warning message at the top of the page. If a second 
 * message is passed in, the second message will be appended to the first.
 *
 * @param message The message to be displayed.
 */
document.displayWarning = function ( message )
{
	if ( !SHOWWARNING ) // defined at the top of the file.
		return;
		
	var warningBox;	
	if ( warningBox = document.getElementById( 'globalWarningBox' ) )
	{
		warningBox.innerHTML += "<br />" + message;
	}
	else
	{
	    	warningBox = document.createElement( 'span' );
		warningBox.className = 'alert';
		warningBox.id = 'globalWarningBox';
		warningBox.style.margin = '0';
		warningBox.style.zIndex = '200';
		warningBox.innerHTML = message;
		document.body.insertBefore( warningBox, document.body.firstChild );
		
	}
	
}

/** This will display an information message at the top of the page. If a 
 * second message is passed in, the second message will be appended to the 
 * first.
 *
 * @param message The message to be displayed.
 */
document.displayInfo = function ( message )
{
	if ( !SHOWINFO ) // defined at the top of the file.
		return;
	
	var infoBox;
	if ( infoBox = document.getElementById( 'globalInfoBox' ) )
	{
		infoBox.innerHTML += "<br />" + message;
	}
	else
	{
	    	infoBox = document.createElement( 'span' );
		infoBox.className = 'info';
		infoBox.id = 'globalInfoBox';
		infoBox.style.margin = '0';
		infoBox.style.zIndex = '200';
		infoBox.style.textAlign = 'left';
		infoBox.innerHTML = message;
		document.body.insertBefore( infoBox, document.body.firstChild );
	}
}	

/** This will display a note at the top of the page. If a second 
 * note is passed in, the second note will be appended to the first.
 *
 * @param message The message to be displayed.
 */
document.displayNote = function ( message )
{
	if ( !SHOWWARNING ) // defined at the top of the file.
		return;
		
	var noteBox;	
	if ( noteBox = document.getElementById( 'globalNoteBox' ) )
	{
		noteBox.innerHTML += "<br />" + message;
	}
	else
	{
	    	noteBox = document.createElement( 'span' );
		noteBox.className = 'note';
		noteBox.id = 'globalNoteBox';
		noteBox.style.margin = '0';
		noteBox.style.zIndex = '200';
		noteBox.innerHTML = message;
		document.body.insertBefore( noteBox, document.body.firstChild );
		
	}
	
}

/** This will display a download message at the top of the page. If a second 
 * message is passed in, the second message will be appended to the first.
 *
 * @param message The message to be displayed.
 */
document.displayDownload = function ( message )
{
	if ( !SHOWWARNING ) // defined at the top of the file.
		return;
		
	var downloadBox;	
	if ( downloadBox = document.getElementById( 'globalDownloadBox' ) )
	{
		downloadBox.innerHTML += "<br />" + message;
	}
	else
	{
	    	downloadBox = document.createElement( 'span' );
		downloadBox.className = 'download';
		downloadBox.id = 'globalDownloadBox';
		downloadBox.style.margin = '0';
		downloadBox.style.zIndex = '200';
		downloadBox.innerHTML = message;
		document.body.insertBefore( downloadBox, document.body.firstChild );
		
	}
	
}

/* This function is to be used to debug new code
 * 
 * @param message The message to be displayed
 * @param level The debug level for this message (optional). Defaults to 1.
 */
document.debug = function ( message, level )
{
	if ( arguments.length <= 1 )
		level = 1;

	if ( DEBUGLEVEL < level ) // defined at the top of the file.
		return;
	document.displayInfo( message );
	document.getElementById( 'globalInfoBox' ).style.fontSize = '80%';
	
}



