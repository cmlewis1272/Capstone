<?php
// Include config file
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$Street_name = "";
$Street_num = "";
$City = "";
$State = "";
$Zip = "";
$Availability = "";

$Street_name_err = "";
$Street_num_err = "";
$City_err = "";
$State_err = "";
$Zip_err = "";
$Availability_err = "";


// Processing form data when form is submitted
if(isset($_POST["Resident_id"]) && !empty($_POST["Resident_id"])){
    // Get hidden input value
    $Resident_id = $_POST["Resident_id"];

    $Street_name = trim($_POST["Street_name"]);
		$Street_num = trim($_POST["Street_num"]);
		$City = trim($_POST["City"]);
		$State = trim($_POST["State"]);
		$Zip = trim($_POST["Zip"]);
		$Availability = trim($_POST["Availability"]);
		

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

    $vars = parse_columns('residents', $_POST);
    $stmt = $pdo->prepare("UPDATE residents SET Street_name=?,Street_num=?,City=?,State=?,Zip=?,Availability=? WHERE Resident_id=?");

    if(!$stmt->execute([ $Street_name,$Street_num,$City,$State,$Zip,$Availability,$Resident_id  ])) {
        echo "Something went wrong. Please try again later.";
        header("location: error.php");
    } else {
        $stmt = null;
        header("location: residents-read.php?Resident_id=$Resident_id");
    }
} else {
    // Check existence of id parameter before processing further
	$_GET["Resident_id"] = trim($_GET["Resident_id"]);
    if(isset($_GET["Resident_id"]) && !empty($_GET["Resident_id"])){
        // Get URL parameter
        $Resident_id =  trim($_GET["Resident_id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM residents WHERE Resident_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_id = $Resident_id;

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

                    $Street_name = $row["Street_name"];
					$Street_num = $row["Street_num"];
					$City = $row["City"];
					$State = $row["State"];
					$Zip = $row["Zip"];
					$Availability = $row["Availability"];
					

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
                                <label>Street_name</label>
                                <input type="text" name="Street_name" maxlength="25"class="form-control" value="<?php echo $Street_name; ?>">
                                <span class="form-text"><?php echo $Street_name_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Street_num</label>
                                <input type="text" name="Street_num" maxlength="10"class="form-control" value="<?php echo $Street_num; ?>">
                                <span class="form-text"><?php echo $Street_num_err; ?></span>
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
                                <label>Availability</label>
                                <input type="number" name="Availability" class="form-control" value="<?php echo $Availability; ?>">
                                <span class="form-text"><?php echo $Availability_err; ?></span>
                            </div>

                        <input type="hidden" name="Resident_id" value="<?php echo $Resident_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="residents-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
