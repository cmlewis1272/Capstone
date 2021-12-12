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
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $Street_name = trim($_POST["Street_name"]);
		$Street_num = trim($_POST["Street_num"]);
		$City = trim($_POST["City"]);
		$State = trim($_POST["State"]);
		$Zip = trim($_POST["Zip"]);
		$Availability = trim($_POST["Availability"]);
		

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
          exit('Something weird happened'); //something a user can understand
        }

        $vars = parse_columns('residents', $_POST);
        $stmt = $pdo->prepare("INSERT INTO residents (Street_name,Street_num,City,State,Zip,Availability) VALUES (?,?,?,?,?,?)");

        if($stmt->execute([ $Street_name,$Street_num,$City,$State,$Zip,$Availability  ])) {
                $stmt = null;
                header("location: residents-index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add a record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

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

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="residents-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>