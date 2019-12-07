<!DOCTYPE html>
<html lang="en">
<head>
	<title>eBank5 Login</title>
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
            <div class="wrap-login100">
              <div class="sectionleft"> </div>
  <form method = "Post"class="login100-form validate-form"/>
    
     <span class="login100-form-ebank">
      E-Bank 5
      </span>
     <span class="login100-form-title">
      Member Login
      </span>
    
    <div class="wrap-input100 validate-input" data-validate = "Username is required">
      <input class="input100" type="text" name="username" placeholder="Username"/>
      <span class="focus-input100"></span>
      <span class="symbol-input100">
        <i class="fa fa-user" aria-hidden="true"></i>
        </span>
      </div>
    
    <div class="wrap-input100 validate-input" data-validate = "Password is required">
      <input class="input100" type="password" name="password" placeholder="Password"/>
      <span class="focus-input100"></span>
      <span class="symbol-input100">
        <i class="fa fa-lock" aria-hidden="true"></i>
        </span>
      </div>
    
    <div class="container-login100-form-btn">
      <button type ="submit" value="Login" class="login100-form-btn">
       Login
        </button>
      </div>
    <div class="text-center p-t-136">
      <a class="txt2" href="registration.php">
        Create your Account
        <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
        </a>
      </div>
    </form>
              <div class="sectionright"> </div>
          </div>
          </header>
		</div>
	</div>
	
	

	
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

<?php
	if(isset($_POST['username']) && isset($_POST['password'])){
		$user = $_POST['username'];
		$pass = $_POST['password'];
		//do further validation?
		try{
			require("config.php");
			//$username, $password, $host, $database
			$conn_string = "mysql:host=$host;dbname=$database;charset=utf8mb4";
			$db = new PDO($conn_string, $username, $password);
			$stmt = $db->prepare("select id, username, password from `Users` where username = :username LIMIT 1");
			$stmt->execute(array(":username"=>$user));
			//print_r($stmt->errorInfo());
			$results = $stmt->fetch(PDO::FETCH_ASSOC);
			//echo var_export($results, true);
			if($results && count($results) > 0){
				//$hash = password_hash($pass, PASSWORD_BCRYPT);
				if(password_verify($pass, $results['password'])){
					echo "Welcome, " . $results["username"];
					echo "[" . $results["id"] . "]";
					$user = array("id"=> $results['id'],
								"name"=> $results['username']
								);
					//TODO refactor
					$sql = "select value from `System_Properties` where `key` = :key";
					$stmt = $db->prepare($sql);
					$r = $stmt->execute(array(":key"=>"admins"));
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					$user["isAdmin"] = false;
					echo var_export($result, true);
					if($result){
						if(strpos($result['value'], ($user["id"]."")) !== false){
							$user["isAdmin"] = true;
						}
					}
					else{
						echo $stmt->errorInfo();
					}
					
					$_SESSION['user'] = $user;
					echo var_export($user, true);
					echo var_export($_SESSION, true);
					header("Location: dashboard.php");
					
				}
				else{
					echo "Invalid password";
				}
			}
			else{
					echo "Invalid username";
			}
		}
		catch(Exception $e){
			echo $e->getMessage();
		}
	}
?>

