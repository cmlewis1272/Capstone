<?php

	
	if (isset($_SESSION['message'])) 
	{
?>
		<div class="alert alert-warning alert-dismissible fade show" role="alert">
  			<?php echo $_SESSION['message']; ?>
  			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
<?php	
	unset($_SESSION['message']);	
	}elseif (isset($_GET['login_warning'])) {
?>
		<div class="alert alert-warning alert-dismissible fade show" role="alert">
  			<?php echo $_GET['login_warning']; ?>
  			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
<?php
	//unset($_GET['login_message']);
	}


?>