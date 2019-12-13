<?php
session_start();
if(isset($_SESSION['user']['name'])){
$user= $_SESSION['user']['name'];
require("config.php");

// Create connection
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

echo "checking: " . $act["chk_act"]. " Savings: " . $act["sav_act"]. " Bitcoin:" . $act["btc_act"]. "<br>";


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
echo $chk_bal_total;
}


?>