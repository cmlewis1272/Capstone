<?php
// Include config file
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$First_name = "";
$Last_name = "";
$Street_num = "";
$Street_name = "";
$City = "";
$State = "";
$Zip = "";
$Username = "";
$Password = "";
$Access_level = "";

$First_name_err = "";
$Last_name_err = "";
$Street_num_err = "";
$Street_name_err = "";
$City_err = "";
$State_err = "";
$Zip_err = "";
$Username_err = "";
$Password_err = "";
$Access_level_err = "";


// Processing form data when form is submitted
if(isset($_POST["User_id"]) && !empty($_POST["User_id"])){
    // Get hidden input value
    $User_id = $_POST["User_id"];

    $First_name = trim($_POST["First_name"]);
		$Last_name = trim($_POST["Last_name"]);
		$Street_num = trim($_POST["Street_num"]);
		$Street_name = trim($_POST["Street_name"]);
		$City = trim($_POST["City"]);
		$State = trim($_POST["State"]);
		$Zip = trim($_POST["Zip"]);
		$Username = trim($_POST["Username"]);
		$Password = trim($_POST["Password"]);
		$Access_level = trim($_POST["Access_level"]);
		

    // Prepare an update statement
    $dsn = "mysql:host=$db_server;dbname=$db_name;charset=utf8mb4";
    $options = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];
    try {
        $pdo = new PDO($dsn, $db_user, $db_password, $options);
    } catch (Exception $e) {
        error_log($e->getMessage());
        exit('Something weird happened');
    }

    $vars = parse_columns('users', $_POST);
    $stmt = $pdo->prepare("UPDATE users SET First_name=?,Last_name=?,Street_num=?,Street_name=?,City=?,State=?,Zip=?,Username=?,Password=?,Access_level=? WHERE User_id=?");

    if(!$stmt->execute([ $First_name,$Last_name,$Street_num,$Street_name,$City,$State,$Zip,$Username,$Password,$Access_level,$User_id  ])) {
        echo "Something went wrong. Please try again later.";
        header("location: error.php");
    } else {
        $stmt = null;
        header("location: users-read.php?User_id=$User_id");
    }
} else {
    // Check existence of id parameter before processing further
	$_GET["User_id"] = trim($_GET["User_id"]);
    if(isset($_GET["User_id"]) && !empty($_GET["User_id"])){
        // Get URL parameter
        $User_id =  trim($_GET["User_id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE User_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_id = $User_id;

            // Bind variables to the prepared statement as parameters
			if (is_int($param_id)) $__vartype = "i";
			elseif (is_string($param_id)) $__vartype = "s";
			elseif (is_numeric($param_id)) $__vartype = "d";
			else $__vartype = "b"; // blob
			mysqli_stmt_bind_param($stmt, $__vartype, $param_id);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value

                    $First_name = $row["First_name"];
					$Last_name = $row["Last_name"];
					$Street_num = $row["Street_num"];
					$Street_name = $row["Street_name"];
					$City = $row["City"];
					$State = $row["State"];
					$Zip = $row["Zip"];
					$Username = $row["Username"];
					$Password = $row["Password"];
					$Access_level = $row["Access_level"];
					

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.<br>".$stmt->error;
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

                        <div class="form-group">
                                <label>First_name</label>
                                <input type="text" name="First_name" maxlength="25"class="form-control" value="<?php echo $First_name; ?>">
                                <span class="form-text"><?php echo $First_name_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Last_name</label>
                                <input type="text" name="Last_name" maxlength="25"class="form-control" value="<?php echo $Last_name; ?>">
                                <span class="form-text"><?php echo $Last_name_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Street_num</label>
                                <input type="number" name="Street_num" class="form-control" value="<?php echo $Street_num; ?>">
                                <span class="form-text"><?php echo $Street_num_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Street_name</label>
                                <input type="text" name="Street_name" maxlength="25"class="form-control" value="<?php echo $Street_name; ?>">
                                <span class="form-text"><?php echo $Street_name_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>City</label>
                                <input type="text" name="City" maxlength="25"class="form-control" value="<?php echo $City; ?>">
                                <span class="form-text"><?php echo $City_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>State</label>
                                <input type="text" name="State" maxlength="2"class="form-control" value="<?php echo $State; ?>">
                                <span class="form-text"><?php echo $State_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Zip</label>
                                <input type="number" name="Zip" class="form-control" value="<?php echo $Zip; ?>">
                                <span class="form-text"><?php echo $Zip_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Username</label>
                                <input type="text" name="Username" maxlength="50"class="form-control" value="<?php echo $Username; ?>">
                                <span class="form-text"><?php echo $Username_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Password</label>
                                <input type="text" name="Password" maxlength="50"class="form-control" value="<?php echo $Password; ?>">
                                <span class="form-text"><?php echo $Password_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Access_level</label>
                                <input type="number" name="Access_level" class="form-control" value="<?php echo $Access_level; ?>">
                                <span class="form-text"><?php echo $Access_level_err; ?></span>
                            </div>

                        <input type="hidden" name="User_id" value="<?php echo $User_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="users-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
