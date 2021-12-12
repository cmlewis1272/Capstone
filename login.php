<!--include for header-->
<?php 

session_start();

include "includes/Header.php"; 


//include for navigation-->
include "includes/Login_nav.php"; 

?>



<body>

  <div class="container">

  <?php include "includes/message.php" ?>

  <form action="includes/logincode.php" method="POST">
    <div class="mb-3 mt-3">
      <label for="email" class="form-label">Username:</label>
      <input type="text" class="form-control" id="email" placeholder="Enter User ID" name="Username">
    </div>
    <div class="mb-3">
      <label for="pwd" class="form-label">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
    </div>
    <div class="form-check mb-3">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="remember"> Remember me
      </label>
    </div>
    <button type="submit" name="login_btn" class="btn btn-primary">Submit</button>
</form>

    

  </div>


<?php include "includes/footer.php"; ?>


