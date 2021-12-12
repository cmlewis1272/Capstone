<?php

session_start();
include "db.php";


if (isset($_POST['login_btn'])) 
{
	$Username = mysqli_real_escape_string($connection, $_POST['Username']);
	$password = mysqli_real_escape_string($connection, $_POST['password']);

	$login_query = "SELECT * FROM users WHERE Username = '$Username' and password='$password' LIMIT 1";
	$login_query_run = mysqli_query($connection, $login_query);

	if (mysqli_num_rows($login_query_run) > 0) {
					
		
		foreach($login_query_run as $data){
			$user_id = $data['User_id'];
			$user_name = $data['First_name'].' '.$data['Last_name'];
			$role_as = $data['Access_level'];
			
		}



		$_SESSION['auth'] = true;
		$_SESSION['auth_role']=$role_as;//1=admin 2=supervisor, 3=field staff
		$_SESSION['auth_user'] = [
			'user_id'=>$user_id,
			'user_name'=>$user_name,
		];

		if ($_SESSION['auth_role'] == 1) // 1 =  manager
		{
			$_SESSION['message'] = "Welcome Manager";
			header("Location: ../index.php");
			exit(0);
		}
		elseif ($_SESSION['auth_role'] == 2) // 2 = supervisor
		{
			$_SESSION['message'] = "Welcome Supervisor";
			header("Location: ../index.php");
			exit(0);
		}
		elseif ($_SESSION['auth_role'] == 3) // 3 = field staff
		{
			$_SESSION['message'] = "Welcome Field Staff";
			header("Location: ../index.php");
			exit(0);
		}

	}
	else
	{

		$_SESSION['message'] = "Sorry! Invalid Email or Password";
		header("Location: ../login.php");
		exit(0);
	}


} 
//else 
//{
	//$_SESSION['message'] = "Sorry! You are not allowed access to this file";
	//header("Location: ../login.php");
	//exit(0);
//}


?>