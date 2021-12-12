<?php
  
  //start session
  session_start(); 

  include "includes/page_security.php";

  //include message when necessary
  include "includes/message.php";

  //<!--include header-->
  include "includes/Header.php"; 


if ($_SESSION['auth_role']) {
  //check role for 1 display manager nav
  if ($_SESSION['auth_role'] == 1)
   {
    include "includes/main_nav.php";

  }
  elseif ($_SESSION['auth_role'] == 2) 
  {
    include "includes/main_nav.php";

  }
  elseif ($_SESSION['auth_role'] == 3) {
    
    include "includes/main_nav.php";
  }

  
}

$query = "select * from residents";
$query1 = "select * from tenants";
$query2 = "select * from donators";
$query3 = "select * from donations";

$result = mysqli_query($connection, $query);
$result1 = mysqli_query($connection, $query1);
$result2 = mysqli_query($connection, $query2);
$result3 = mysqli_query($connection, $query3);


$num_residents = mysqli_num_rows($result);
$num_tenants = mysqli_num_rows($result1);
$num_donators = mysqli_num_rows($result2);
$num_donations = mysqli_num_rows($result3);
  
?>



<body>

  <div class="container">

    <!--beginning of cards section-->
    <div class="row mt-5"> 
      
      <div class="col-lg-3">
        <div class="card text-white bg-primary" style="width: 18rem;">
        <div class="card-header"><h2>Residences</h2></div>
        <div class="card-body">
          <h5 class="card-title"><?php echo $num_residents." "."Residences" ?></h5>
          <p class="card-text"></p>
         
        </div>
      </div>

      </div><!--end of card one-->

      <div class="col-lg-3">
        <div class="card text-white bg-warning" style="width: 18rem;">
        <div class="card-header"><h2>Tenants</h2></div>
        <div class="card-body">
          <h5 class="card-title"><?php echo $num_tenants." "."Tenants" ?></h5>
          <p class="card-text"></p>
          
        </div>
      </div>
        
      </div><!--end of card two--> 

      
      <div class="col-lg-3">
        <div class="card text-white bg-success" style="width: 18rem;">
        <div class="card-header"><h2>Donators</h2></div>
        <div class="card-body">
          <h5 class="card-title"><?php echo $num_donators." "."Donators" ?></h5>
          <p class="card-text"></p>
                  </div>
      </div>
      </div><!--end of card three--> 

      <div class="col-lg-3">
        <div class="card text-white bg-info" style="width: 18rem;">
        <div class="card-header"><h2>Donations</h2></div>
        <div class="card-body">
          <h5 class="card-title"><?php echo $num_donations." "."Donations" ?></h5>
          <p class="card-text"></p>
    
        </div>
      </div>
      </div><!--end of card four-->       


    </div>

  </div>


<?php include "includes/footer.php"; ?>


