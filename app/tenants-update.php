<?php
// Include config file
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$Resident_id = "";
$First_name = "";
$Last_name = "";
$Phone = "";

$Resident_id_err = "";
$First_name_err = "";
$Last_name_err = "";
$Phone_err = "";


// Processing form data when form is submitted
if(isset($_POST["Tenant_id"]) && !empty($_POST["Tenant_id"])){
    // Get hidden input value
    $Tenant_id = $_POST["Tenant_id"];

    $Resident_id = trim($_POST["Resident_id"]);
		$First_name = trim($_POST["First_name"]);
		$Last_name = trim($_POST["Last_name"]);
		$Phone = trim($_POST["Phone"]);
		

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

    $vars = parse_columns('tenants', $_POST);
    $stmt = $pdo->prepare("UPDATE tenants SET Resident_id=?,First_name=?,Last_name=?,Phone=? WHERE Tenant_id=?");

    if(!$stmt->execute([ $Resident_id,$First_name,$Last_name,$Phone,$Tenant_id  ])) {
        echo "Something went wrong. Please try again later.";
        header("location: error.php");
    } else {
        $stmt = null;
        header("location: tenants-read.php?Tenant_id=$Tenant_id");
    }
} else {
    // Check existence of id parameter before processing further
	$_GET["Tenant_id"] = trim($_GET["Tenant_id"]);
    if(isset($_GET["Tenant_id"]) && !empty($_GET["Tenant_id"])){
        // Get URL parameter
        $Tenant_id =  trim($_GET["Tenant_id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM tenants WHERE Tenant_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_id = $Tenant_id;

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

                    $Resident_id = $row["Resident_id"];
					$First_name = $row["First_name"];
					$Last_name = $row["Last_name"];
					$Phone = $row["Phone"];
					

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
                                <label>Resident_id</label>
                                <input type="number" name="Resident_id" class="form-control" value="<?php echo $Resident_id; ?>">
                                <span class="form-text"><?php echo $Resident_id_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>First_name</label>
                                <textarea name="First_name" class="form-control"><?php echo $First_name ; ?></textarea>
                                <span class="form-text"><?php echo $First_name_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Last_name</label>
                                <textarea name="Last_name" class="form-control"><?php echo $Last_name ; ?></textarea>
                                <span class="form-text"><?php echo $Last_name_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="Phone" maxlength="20"class="form-control" value="<?php echo $Phone; ?>">
                                <span class="form-text"><?php echo $Phone_err; ?></span>
                            </div>

                        <input type="hidden" name="Tenant_id" value="<?php echo $Tenant_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="tenants-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
