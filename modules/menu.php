<?php

#if ( !function_exists( 'create_list' ))
function create_list( $list ){
	$returnvalue = "<ul>";
	foreach( $list as $key => $value )
	{
		if ( $key === 0 ) continue;
		$returnvalue .= "<li>";
		if ( is_array( $value ))
		{
			if ( isset( $value[ 0 ] ) )
			{
				$returnvalue .= "<a href='".$value[0]."'>$key</a>";
			}
			else
			{
				$returnvalue .=  "<a href='javascript:void(0)'>$key</a>";
			}
			$returnvalue .=  create_list( $value );

		}
		else
		{
			$returnvalue .= "<a href='$value'>$key</a>";
		}
		$returnvalue .= "</li>";
	}
	$returnvalue .= "</ul>";
	return $returnvalue;
}

echo "<div class='menu' id='". $this->get_opt( 'id' ) ."'>";
echo create_list( $this->get_opt( 'menu' ));
echo "</div>";

?>
