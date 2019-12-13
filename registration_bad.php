<?php
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<html lang="en">
<head>
	<title>Registration</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
<script>
$(document).ready(function(){
	$('#register_form').submit(function(event){
		if(this.password.value.length == 0 || this.confirm.value.length == 0){
			alert("Please enter a password and confirm it");
			return false;
		}
		let isOk = this.password.value == this.confirm.value;
		if(!isOk){
			alert("Password and Confirm password don't match");
		}
		return isOk;
	});
});

</script>
</head>
<body>
	<div class="limiter">
	  <div class="container-login100">
	  	<div class="wrap-login100">
	  	     <span class="login100-form-ebank">
      E-Bank 5
      </span>
	  	<div class="sectionleft"> </div>
		<form id="register_form" method="POST"/>
	  
		  <div><span class="login100-form-title"><strong> Registration </strong></span>
		    
		    <div class="wrap-input100" id="User"> 
						<input type="text"
						name="username"  
						class="input100"
						placeholder="Username"/>
						
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
		    </div>
			 			
 			<div class="wrap-input100" id="Password"> 
					<input type="password" 
					name="password" 
					class="input100"
					placeholder="Password"/>
					<span class="symbol-input100">
						<i class="fa fa-lock" aria-hidden="true"></i>
					</span>
			</div>
	  		
	  		<div class="wrap-input100" id="Confirm"> 
					<input type="password" 
					name="confirm" 
					class="input100"
					placeholder="Verify Password"/>
					<span class="symbol-input100">
						<i class="fa fa-lock" aria-hidden="true"></i>
					</span>
			</div>		
		  				
  			 <div id="Register">
  			  		<input type="submit" 
  			  		value="Register" 
  			  		class="login100-form-btn" 
  			  		/>
  			</div>
  			
  			<div class="text-center p-t-136"> 
		  <a class="text-center p-t-136" href="index.php"> <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i> Return to Login </a>		
		  </div>  
		  </div>
		</form>
		<div class="sectionright"> </div>
	</div>
	</div>
</div>
</body>
</html>


<?php

    $chk = rand(10000000,99999999);
    $sav = rand(10000000,99999999);
    $btc = rand(10000000,99999999);

	if(isset($_POST['username']) 
		&& isset($_POST['password'])
		&& isset($_POST['confirm'])){
			
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$confirm = $_POST['confirm'];
		if($pass != $confirm){
				echo "Passwords don't match";
				exit();
		}
		


		//do further validation?
		try{
			//do hash of password
			$hash = password_hash($pass, PASSWORD_BCRYPT);
			require("config.php");
			//$username, $password, $host, $database
			$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
			$db = new PDO($conn_string, $username, $password);
			$stmt = $db->prepare("INSERT into `Users` (`username`, `password`, 'chk_act', 'sav_act', 'btc_act') VALUES(:username, :password, :chk_act, :sav_act, :btc_act)");
			$result = $stmt->execute(
				array(":username"=>$user,
					":password"=>$hash,
					":chk_act"=>$chk,
					":sav_act"=>$sav,
					":btc_act"=>$btc
				)
			);
			print_r($stmt->errorInfo());
			
			echo var_export($result, true);
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}
?>
