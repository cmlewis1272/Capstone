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
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $Donator_type = trim($_POST["Donator_type"]);
		$Organization_name = trim($_POST["Organization_name"]);
		$Donator_FirstName = trim($_POST["Donator_FirstName"]);
		$Donator_LastName = trim($_POST["Donator_LastName"]);
		$Street_num = trim($_POST["Street_num"]);
		$Street_name = trim($_POST["Street_name"]);
		$City = trim($_POST["City"]);
		$State = trim($_POST["State"]);
		$zip = trim($_POST["zip"]);
		

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

        $vars = parse_columns('donators', $_POST);
        $stmt = $pdo->prepare("INSERT INTO donators (Donator_type,Organization_name,Donator_FirstName,Donator_LastName,Street_num,Street_name,City,State,zip) VALUES (?,?,?,?,?,?,?,?,?)");

        if($stmt->execute([ $Donator_type,$Organization_name,$Donator_FirstName,$Donator_LastName,$Street_num,$Street_name,$City,$State,$zip  ])) {
                $stmt = null;
                header("location: donators-index.php");
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

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="donators-index.php" class="btn btn-secondary">Cancel</a>
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