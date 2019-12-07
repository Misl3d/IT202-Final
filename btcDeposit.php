<?php
include_once("helpers/functions.php");
?>

<html lang="en">
<head>
	<title>Dashboard</title>
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
</head>
<body>
<div class="limiter">
<div class="container-login100"> 
<header class="WelcomeHead">Bitcoin Deposit</header>

<div class="dash-time">
<div>
Today is 
<?php
echo  date("l F jS, Y") .  "<br>";
echo  date("g:i A") . "<br>";
?>
</div>
</div><br>

<div class=dash-main> 
	<div class="dash-chk">
		<div class="dash-title">
		Bitcoin
		</div>
		<div class="dash-bal">
			$00.00
		</div>
		<div align="center">
			<?php 
  			$url = "https://bitpay.com/api/rates";
  			$json = json_decode(file_get_contents($url));
  			$dollar = $btc = 0;
  			foreach($json as $obj){
	  		if($obj->code =='USD') $btc = $obj->rate;
  			}
    		echo '1 BTC = $'. $btc; 
			?>
		</div>
	</div>
	<div class="dash-transactions">
	  <div class="trans-amount"><label for="number">Amount: </label><br>
      <div class="amount-border">
     $ <input type="number" name="number" id="amount" placeholder $000.00>
     </div><br>
      <div class="container-trans-btn">
      <button type ="submit" value="Deposit" class="login100-form-btn">
       Deposit
        </button>
      </div>
	</div>
	</div><br>
	

	<footer>
	<div class="text-center p-t-136">
	<div class=dash-home>
		<i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
       <a class="dash-logout" href="dashboard.php">Back to Home</a>
	</div>
   </div></footer>
</div>
	
    
       

</div>	
</div>	
</body>
<head>
<title>Deposit</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
<link rel="icon" type="image/png" href="images/icons/favicon.ico">
<!--===============================================================================================-->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<!--===============================================================================================-->
<link href="fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!--===============================================================================================-->
<link href="vendor/animate/animate.css" rel="stylesheet" type="text/css">
<!--===============================================================================================-->
<link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" type="text/css">
<!--===============================================================================================-->
<link href="vendor/select2/select2.min.css" rel="stylesheet" type="text/css">
<!--===============================================================================================-->
<link href="css/util.css" rel="stylesheet" type="text/css">
<link href="css/main.css" rel="stylesheet" type="text/css">
<!--===============================================================================================-->
</head>
<body>

				


<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>