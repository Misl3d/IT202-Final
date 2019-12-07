<?php
include_once("helpers/functions.php");
include_once("partials/header.php");
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
<header class="WelcomeHead">Welcome, <?php get_username();?>.</header>

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
		Checking
		</div>
		<div class="dash-bal">
			$00.00
		</div>
		<div class="dash-nav">
			<ul>
  				<li><a href="chkWithdraw.php">Withdraw</a></li> 
  				<li><a href="chkTransfer.php">Transfer</a></li> 
  				<li><a href="chkDeposit.php">Deposit</a></li> 
			</ul>
		</div>
	</div>
	</header>
	<div class="dash-sav">
		<div class="dash-title">
			Savings
		</div>
		<div class="dash-bal">
			$00.00
		</div>
		<div class="dash-nav">
			<ul>
  				<li><a href="savWithdraw.php">Withdraw</a></li> 
  				<li><a href="savTransfer.php">Transfer</a></li> 
  				<li><a href="savDeposit.php">Deposit</a></li> 
			</ul>
		</div>
	</div>
	
	<div class="dash-btc">
		<div class="dash-title">
			Bitcoin
		</div>
		<div class="dash-bal-btc">
			$00.00
			<font size="3px">
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
		</font>
		</div>

		<div class="dash-nav">
			<ul>
  				<li><a href="btcWithdraw.php">Withdraw</a></li> 
  				<li><a href="btcTransfer.php">Transfer</a></li> 
  				<li><a href="btcDeposit.php">Deposit</a></li> 
			</ul>
		</div>
	</div>
	<footer>
	<div class="text-center p-t-136">
	<div class=dash-logout>
		<i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
       <a class="dash-logout" href="logout.php">Log Out</a>
	</div>
   </div></footer>
</div>
	
    
       

</div>	
</div>	
</body>
<head>
<title>Dashboard</title>
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