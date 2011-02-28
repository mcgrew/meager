<?php
/*
	Module
	=====
		__Search__
			Adds a search box which performs a google site search on submission.

		Options
		-------
			class_class : The class name to use for the search box div.
			container_id : The id to use for the search box div. Defaults to 'searchBox'.
			focus_action : The action to perform when the box is focused. Should be
				one of 'select', 'select_if_default', 'clear', 'clear_if_default', or
				'no_action'. Defaults to 'select'.
			default_value : The value the box will be filled with when the page loads.
*/

// no direct access
defined( '_VALID_' ) or die( 'Access Denied' );
$FOCUS_ACTION = array(  "select"            => "this.select()",
                        "select_if_default" => "if(this.value==this.defaultValue){this.select()}",
                        "clear"             => "this.value=\"\"",
                        "clear_if_default"  => "if(this.value==this.defaultValue){this.value=\"\"}",
                        "no_action"         => "" );

$container_class = $this->get_opt( 'container_class', '');
$container_id    = $this->get_opt( 'container_id', "SearchBox" );
$focusAction     = $FOCUS_ACTION[  $this->get_opt( 'focus_action', 'select')  ];
$defaultValue    = $this->get_opt( 'default_value', "" );

echo "
<div class='searchBox $container_class' id='$container_id'>

<form name='BannerSearchBoxForm' id='search_box_form' method='get' action='http://www.google.com/search' onsubmit='this.q.value = \"site:".$_SERVER['SERVER_NAME']." \"+this.q.value;'>
        <input class='search_box_text' name='q' value='$defaultValue' id='headerSearchInput' onfocus='$focusAction' type='text' style='height:18px;' />
        <input type='submit' value='SEARCH' alt='Submit' id='headerSearchButton' style='vertical-align:top;' />
</form>

</div>"

?>

