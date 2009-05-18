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
<script type='text/javascript'><!--

function searchEcoliWebsearch(frm)
{
	var myVal = 'index.php?option=com_wrapper%26Itemid=250%26query=';
	var query = frm.query.value;
	var urlForward = myVal + query;
	var url = 'logSearches.php?query=' + query + '&url_forward=' + urlForward;
	window.open(url, '_self');
	return false;
}

--></script>
<div class='search_box module$moduleclass_sfx' id='$containerID'>

<form name='BannerSearchBoxForm' id='search_box_form' method='get' onsubmit='return searchEcoliWebsearch(this);'>
        <input class='search_box_text' name='query' value='$defaultValue' id='headerSearchInput' onfocus='$focusAction' type='text' style='height:18px;' />
        <input type='submit' value='SEARCH' alt='Submit' id='headerSearchButton' style='vertical-align:top;' />
        </a>
</form>

</div>"

?>

