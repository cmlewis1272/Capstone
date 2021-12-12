<?php

//arrays for fill in
$manager_nav_config_array = array(

		//headings
		array("residents","tenants","Donators","Donations","Users"),

		//functions
		array("Add Residence","Add Tenant","Add Donators","Add Donations","Add Users"),

		//reports
		array("Tax Reciept", "Residence Report"),
	); 

$supervisor_nav_config_array = array(

		//headings
		array("residents","tenants","donators","donations","users"),

		//functions
		array("Add Residence","Add Tenant","Add Donators","Add Donations","Add Users"),

		//reports
		array("Tax Reciept", "Residence Report"),
	);

$fieldstaff_nav_config_array = array(

		//headings
		array("residents","Tenants"),

		//functions
		array("Add Tenant"),

		//reports
		array("Residence Report"),
	);


//check session variable
if (isset($_SESSION['auth_role'])) {
	

//depend on value of session[auth]
	//choose array set for manager if auth_role = 1
	if($_SESSION['auth_role'] == 1){
		$nav_choice = $manager_nav_config_array;
	}elseif ($_SESSION['auth_role'] == 2) {
		$nav_choice = $supervisor_nav_config_array;
	}elseif ($_SESSION['auth_role'] == 3) {
		$nav_choice = $fieldstaff_nav_config_array;
	}
			

}



?>