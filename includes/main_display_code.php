<?php

//constanst defined

$Table_name = $_GET['table']; 







//check Table_name variable
if ($Table_name != "") {
	


	//choose array set for manager if auth_role = 1
	if($Table_name == "users"){
		$Table_choice = $user_display_config_array;
	}elseif ($Table_name == "Tenants") {
		$nav_choice = $supervisor_nav_config_array;
	}elseif ($Table_name == "Donators") {
		$nav_choice = $fieldstaff_nav_config_array;
	}
			

}


?>

