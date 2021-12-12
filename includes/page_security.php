<?php

	if (isset($_SESSION['auth']) == false) {
		//send message you need to login and redirect to login screen
		$_GET['login_warning']= "Access restricted please login first.";
		header("Location: login.php");
		exit(0);
	}

?>