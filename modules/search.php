<?php
/** Searh box module for the header.
 * @author Thomas McGrew
 * @date Sept. 12, 2008
 */


// no direct access
defined( '_VALID_' ) or die( 'Access Denied' );
$FOCUS_ACTION = array(  "select"            => "this.select()",
                        "select_if_default" => "if(this.value==this.defaultValue){this.select()}",
                        "clear"             => "this.value=\"\"",
                        "clear_if_default"  => "if(this.value==this.defaultValue){this.value=\"\"}",
                        "no_action"         => "" );

$moduleclass_sfx = $this->get_opt( 'moduleclass_sfx', '');
$containerID     = $this->get_opt( 'containerId', "headerSearchBox" );
$focusAction     = $FOCUS_ACTION[  $this->get_opt( 'focus_action', 0)  ];
$defaultValue    = $this->get_opt( 'default_value', "" );

echo "
<div class='search_box module$moduleclass_sfx' id='$containerID'>

<form name='BannerSearchBoxForm' id='search_box_form' method='get' action='http://www.google.com/search' onsubmit='this.q.value = \"site:".$_SERVER['SERVER_NAME']." \"+this.q.value;'>
        <input class='search_box_text' name='q' value='$defaultValue' id='headerSearchInput' onfocus='$focusAction' type='text' style='height:18px;' />
        <input type='submit' value='SEARCH' alt='Submit' id='headerSearchButton' style='vertical-align:top;' />
</form>

</div>"

?>

