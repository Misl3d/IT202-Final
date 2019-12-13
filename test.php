<?php
session_start();
if (isset($POST['username'])) {
$user= $POST['username'];
require("config.php");
$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
$db = new PDO($conn_string, $username, $password);

/*$act = "SELECT `chk_act`, `sav_act`, `btc_act` from Users where username='$user'";
$result = mysqli_query($conn, $act);
*/
$sql = "SELECT `chk_act`, `sav_act`, `btc_act` from Users where username='$user'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>
