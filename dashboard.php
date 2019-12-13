<?php
include_once("helpers/functions.php");
include_once("partials/header.php");
?>

<?php
if(isset($_SESSION['user']['name'])){
$user= $_SESSION['user']['name'];
require("config.php");

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT `chk_act`, `sav_act`, `btc_act` from Users where username='$user'";
$result = mysqli_query($conn, $sql);
$act = mysqli_fetch_assoc($result);
	$sav_act = $act["sav_act"];
	$chk_act = $act["chk_act"];
	$btc_act = $act["btc_act"];

$sql = "SELECT SUM(Amount) as Total FROM `transactions` WHERE AccountSource= '$chk_act'";
$result = mysqli_query($conn, $sql);
	$chk_bal = mysqli_fetch_assoc($result);
	
$sql = "SELECT SUM(Amount) as Total FROM `transactions` WHERE AccountSource= '$sav_act'";
$result = mysqli_query($conn, $sql);
	$sav_bal = mysqli_fetch_assoc($result);
	
$sql = "SELECT SUM(Amount) as Total FROM `transactions` WHERE AccountSource= '$btc_act'";
$result = mysqli_query($conn, $sql);
	$btc_bal = mysqli_fetch_assoc($result);
	
	foreach($chk_bal as $value){
		$chk_bal_total = "$$value";
	}
	
	foreach($btc_bal as $value){
		$btc_bal_total = "$$value";
	}
	
	foreach($sav_bal as $value){
		$sav_bal_total = "$$value";
	}



}

?>

<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function do_bank_action($account1, $account2, $amountChange, $type){
	require("config.php");
	$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
	$db = new PDO($conn_string, $username, $password);
	$a1total = 0;//TODO get total of account 1
	$a2total = 0;//TODO get total of account 2
	$query = "INSERT INTO `transactions` (`AccountSource`, `AccountDest`, `Amount`, `Type`, `Total`) 
	VALUES(:p1a1, :p1a2, :p1change, :type, :a1total), 
			(:p2a1, :p2a2, :p2change, :type, :a2total)";
	
	$stmt = $db->prepare($query);
	$stmt->bindValue(":p1a1", $account1);
	$stmt->bindValue(":p1a2", $account2);
	$stmt->bindValue(":p1change", $amountChange);
	$stmt->bindValue(":type", $type);
	$stmt->bindValue(":a1total", $a1total);
	//flip data for other half of transaction
	$stmt->bindValue(":p2a1", $account2);
	$stmt->bindValue(":p2a2", $account1);
	$stmt->bindValue(":p2change", ($amountChange*-1));
	$stmt->bindValue(":type", $type);
	$stmt->bindValue(":a2total", $a2total);
	$result = $stmt->execute();
	return $result;
	unset($_POST['amount']);
	unset($_POST['type']);
	unset($_POST['account1']);
	unset($_POST['account2']);

	header("Refresh:0");
}
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
date_default_timezone_set('US/Eastern');
echo  date("l F jS, Y") .  "<br>";
echo  date("g:i A") . "<br>";
?>
</div>
</div><br>


<div class=dash-main> 
		<div class="dash-navigation">
			<ul>
  				<a class="list" href="dashboard.php?type=withdraw">Withdraw</a> 
  				<a class="list" href="dashboard.php?type=transfer">Transfer</a> 
  				<a class="list" href="dashboard.php?type=deposit">Deposit</a>
			</ul>
		</div>
	<div class="dash-chk">
		<div class="dash-title">
		Checking
		</div>
		<div class="dash-bal">
		<?php echo  $chk_bal_total ?>
		</div>
		<div class="dash-act-num">
		#:
		<?php echo  $chk_act ?>
		</div>
	</div>
	</header>
	<div class="dash-sav">
		<div class="dash-title">
			Savings
		</div>
		<div class="dash-bal">
		<?php echo  $sav_bal_total ?>
		</div>
		<div class="dash-act-num">
		#:
		<?php echo  $sav_act ?>
		</div>
	</div>
	
	<div class="dash-btc">
		<div class="dash-title">
			Bitcoin
		</div>
		<div class="dash-bal-btc">
		<?php echo  $btc_bal_total ?>
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
		<div class="dash-act-num">
		#:
		<?php echo  $btc_act ?>
		</div>
	</div>
	<div class="dash-transactions">
	<form method="POST">
	<div class="dash-radio"> 
	<div class="dash-radio-txt">
	Account: 
	<br>
	<input type="radio" name="account1"
	<?php if (isset($account1) && $account1=="checking") echo "checked";?>
	value="<?php echo $chk_act;?>">Checking <br>
	<input type="radio" name="account1"
	<?php if (isset($account1) && $account1=="savings") echo "checked";?>
	value="<?php echo $sav_act;?>">Savings <br>
	<input type="radio" name="account1"
	<?php if (isset($account1) && $account1=="bicoin") echo "checked";?>
	value="<?php echo $btc_act;?>">Bitcoin
	</div>
	</div>
	
	<div class="dash-radio"> 
	<div class="dash-radio-txt">
	<?php if($_GET['type'] == 'transfer') : ?>
	Recieving: <br>
	<input type="radio" name="account2"
	<?php if (isset($account2) && $account2=="checking") echo "checked";?>
	value="<?php echo $chk_act;?>">Checking <br>
	<input type="radio" name="account2"
	<?php if (isset($account2) && $account2=="savings") echo "checked";?>
	value="<?php echo $sav_act;?>">Savings <br>
	<input type="radio" name="account2"
	<?php if (isset($account2) && $account2=="bicoin") echo "checked";?>
	value="<?php echo $btc_act;?>">Bitcoin
	<?php elseif($_GET['type'] == '') : ?>
	<?php endif; ?>

	
	<input type="number" name="amount" placeholder="$000.00"/>
	<input type="hidden" name="type" value="<?php echo $_GET['type'];?>"/>
	</div>
	</div>
	<div class="dash-radio"> 
	<div class="dash-radio-txt">
	<div class="move-money">
      <button type ="submit" value="Login" class="login100-form-btn">
       Move Money
        </button>
      </div>
	</div>
	</div>
	</div>

	

</form>
<?php
if(isset($_POST['type']) && isset($_POST['account1']) && isset($_POST['amount'])){
	$type = $_POST['type'];
	$amount = (int)$_POST['amount'];
	switch($type){
		case 'deposit':
			do_bank_action("00000000", $_POST['account1'], ($amount * -1), $type);
			break;
		case 'withdraw':
			do_bank_action($_POST['account1'], "00000000", ($amount * -1), $type);
			break;
		case 'transfer':
			do_bank_action($_POST['account1'], $_POST['account2'], ($amount * -1), $type);
		break;
	}
}
?>
	</div>
	<footer>
	<div class="logout-center">
	<div class=dash-logout>
		<i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
       <a class="dash-logout" href="logout.php">Log Out</a>
	</div>

   </footer>
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