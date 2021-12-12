<?php
// Include config file
require_once "config.php";
require_once "helpers.php";

// Define variables and initialize with empty values
$Donator_type = "";
$Organization_name = "";
$Donator_FirstName = "";
$Donator_LastName = "";
$Street_num = "";
$Street_name = "";
$City = "";
$State = "";
$zip = "";

$Donator_type_err = "";
$Organization_name_err = "";
$Donator_FirstName_err = "";
$Donator_LastName_err = "";
$Street_num_err = "";
$Street_name_err = "";
$City_err = "";
$State_err = "";
$zip_err = "";


// Processing form data when form is submitted
if(isset($_POST["Donator_id"]) && !empty($_POST["Donator_id"])){
    // Get hidden input value
    $Donator_id = $_POST["Donator_id"];

    $Donator_type = trim($_POST["Donator_type"]);
		$Organization_name = trim($_POST["Organization_name"]);
		$Donator_FirstName = trim($_POST["Donator_FirstName"]);
		$Donator_LastName = trim($_POST["Donator_LastName"]);
		$Street_num = trim($_POST["Street_num"]);
		$Street_name = trim($_POST["Street_name"]);
		$City = trim($_POST["City"]);
		$State = trim($_POST["State"]);
		$zip = trim($_POST["zip"]);
		

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

    $vars = parse_columns('donators', $_POST);
    $stmt = $pdo->prepare("UPDATE donators SET Donator_type=?,Organization_name=?,Donator_FirstName=?,Donator_LastName=?,Street_num=?,Street_name=?,City=?,State=?,zip=? WHERE Donator_id=?");

    if(!$stmt->execute([ $Donator_type,$Organization_name,$Donator_FirstName,$Donator_LastName,$Street_num,$Street_name,$City,$State,$zip,$Donator_id  ])) {
        echo "Something went wrong. Please try again later.";
        header("location: error.php");
    } else {
        $stmt = null;
        header("location: donators-read.php?Donator_id=$Donator_id");
    }
} else {
    // Check existence of id parameter before processing further
	$_GET["Donator_id"] = trim($_GET["Donator_id"]);
    if(isset($_GET["Donator_id"]) && !empty($_GET["Donator_id"])){
        // Get URL parameter
        $Donator_id =  trim($_GET["Donator_id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM donators WHERE Donator_id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_id = $Donator_id;

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

                    $Donator_type = $row["Donator_type"];
					$Organization_name = $row["Organization_name"];
					$Donator_FirstName = $row["Donator_FirstName"];
					$Donator_LastName = $row["Donator_LastName"];
					$Street_num = $row["Street_num"];
					$Street_name = $row["Street_name"];
					$City = $row["City"];
					$State = $row["State"];
					$zip = $row["zip"];
					

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
                                <label>Donator_type</label>
                                <textarea name="Donator_type" class="form-control"><?php echo $Donator_type ; ?></textarea>
                                <span class="form-text"><?php echo $Donator_type_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Organization_name</label>
                                <textarea name="Organization_name" class="form-control"><?php echo $Organization_name ; ?></textarea>
                                <span class="form-text"><?php echo $Organization_name_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Donator_FirstName</label>
                                <textarea name="Donator_FirstName" class="form-control"><?php echo $Donator_FirstName ; ?></textarea>
                                <span class="form-text"><?php echo $Donator_FirstName_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Donator_LastName</label>
                                <textarea name="Donator_LastName" class="form-control"><?php echo $Donator_LastName ; ?></textarea>
                                <span class="form-text"><?php echo $Donator_LastName_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Street_num</label>
                                <input type="number" name="Street_num" class="form-control" value="<?php echo $Street_num; ?>">
                                <span class="form-text"><?php echo $Street_num_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>Street_name</label>
                                <textarea name="Street_name" class="form-control"><?php echo $Street_name ; ?></textarea>
                                <span class="form-text"><?php echo $Street_name_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>City</label>
                                <textarea name="City" class="form-control"><?php echo $City ; ?></textarea>
                                <span class="form-text"><?php echo $City_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>State</label>
                                <textarea name="State" class="form-control"><?php echo $State ; ?></textarea>
                                <span class="form-text"><?php echo $State_err; ?></span>
                            </div>
						<div class="form-group">
                                <label>zip</label>
                                <input type="number" name="zip" class="form-control" value="<?php echo $zip; ?>">
                                <span class="form-text"><?php echo $zip_err; ?></span>
                            </div>

                        <input type="hidden" name="Donator_id" value="<?php echo $Donator_id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="donators-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
