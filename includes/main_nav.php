<!--Navigation bar section

This navigation is the main nav for the whole site
what headings, functions, and reports are available for the user
logged in is determined by the session variable input from login.This 
will be an include so the session does not need to be started on this 
page.-->

<?php include "navigation_security.php"; ?>



<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">House of Esther</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>

        <!--Navigation headers controlled by code -->
<?php
        
        for ($row=0; $row < sizeof($nav_choice[0]) ; $row++) {
?>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo 'app/'.$nav_choice[0][$row].'-index.php'; ?>" >
                  <?php echo $nav_choice[0][$row] ?></a>
              </li>  
 <?php              
          }
     
        
?>
      
        <!--End of navigation headers-->


<!--
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Functions
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">-->



            <!--Functions menu to be controlled by code -->
     
  
          <!--------------------end of reports ------------------------------->


        </li>
          <li class="nav-item ms-auto dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $_SESSION['auth_user']['user_name']; ?></a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="#">Profile</a></li>
              <li><a class="dropdown-item" href="logout.php?log=true">Logout</a></li>
            </ul>
        </li>
      </ul>
    </div>
  </div>
</nav><!--Navigation section Ends-->