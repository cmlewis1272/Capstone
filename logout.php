<?php
session_start();

if (isset($_GET['log'])) {
	//session destroy
	unset($_SESSION['auth']);
	unset($_SESSION['auth_role']);
	unset($_SESSION['auth_user']);


	$_SESSION["message"] = "Logged Out Successfully";
	header("Location: login.php");
	
}



?>