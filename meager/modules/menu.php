<?php
/*
	Module
	======
		__Menu__
			Creates a list for use as a web site menu.

		Options
		-------
			id : The id for the menu div.
			menu : an array containing the menu items.


			example menu array:
			$menu = array(
				'Home' => '/',
				'Help' => array(
					'FAQ' => 'help/faq.php'
				),
			);
*/
#if ( !function_exists( 'create_list' ))
function create_list( $list ){
	$returnvalue = "<ul class='menuList'>";
	foreach( $list as $key => $value ) {
		if ( $key === 0 ) continue;
		$returnvalue .= "<li class='menuItem'>";
		if ( is_array( $value )) {
			if ( isset( $value[ 0 ] ) ) {
				$returnvalue .= "<a href='".$value[0]."'>$key</a>";
			} else {
				$returnvalue .=  "<a href='javascript:void(0)'>$key</a>";
			}
			$returnvalue .=  create_list( $value );

		} else {
			$returnvalue .= "<a href='$value'>$key</a>";
		}
		$returnvalue .= "</li>";
	}
	$returnvalue .= "</ul>";
	return $returnvalue;
}

echo "<div class='menu' id='". $this->get_opt( 'id' ) ."'>";
echo create_list( $this->get_opt( 'menu' ));
echo "<div class='clear' style='height:0'></div>";
echo "</div>";

?>
