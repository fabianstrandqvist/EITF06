<?php 

	error_reporting(E_ALL);
	ini_set('display_errors', 1);


	require_once 'startsession.php';

// CSRF token generation
$csrfToken = $_SESSION['csrf_token'];

	// Function to check if a password is common
	function isCommonPassword($password) {
		$commonPasswords = file(__DIR__ . '/commonpasswords.txt', FILE_IGNORE_NEW_LINES);
		return in_array($password, $commonPasswords);
	}

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		// Verify CSRF token
		if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $csrfToken) {
			die("CSRF token validation failed.");
		}

		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		$address = $_POST['address'];

		$sql_sanitized_user_name = mysqli_real_escape_string($con, $user_name);
		$xss_sanitized_user_name = htmlspecialchars($sql_sanitized_user_name, ENT_QUOTES, 'UTF-8');
		$sanitized_password = mysqli_real_escape_string($con, $password);
		$sanitized_address = mysqli_real_escape_string($con, $address);	

		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);
		$special   = preg_match('@[\!\@\#\$\%\^\&\*\(\)\_\+]@', $password);

		$valid = $uppercase && $lowercase && $number && $special && strlen($password) >= 8;

		if(!empty($xss_sanitized_user_name) && !empty($sanitized_password) && !is_numeric($user_name) && $valid)
		{
			if (isCommonPassword($password)) {
				echo "Password is too common.";
			}
			elseif (empty($sanitized_address)) {
				echo "Address is required.";
			}
			else{
				$hashed_password = password_hash($sanitized_password, PASSWORD_DEFAULT);
				//save to database
				$user_id = random_num(20);
				$query = "insert into users (user_id,user_name,password,address) values ('" . $user_id . "','" . $xss_sanitized_user_name . "','" . $hashed_password . "', '" . $sanitized_address . "')";

				mysqli_query($con, $query);

				header("Location: login1.php");
				die;
			}
		}
		else
		{
			echo "Password must be at least 8 characters long, contain at least one upper case character, one special character,
			and one number.";
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
</head>
<body>

	<style type="text/css">
	
	#text{

		height: 25px;
		border-radius: 5px;
		padding: 4px;
		border: solid thin #aaa;
		width: 100%;
	}

	#button{

		padding: 10px;
		width: 100px;
		color: white;
		background-color: lightblue;
		border: none;
	}

	#box{

		background-color: grey;
		margin: auto;
		width: 300px;
		padding: 20px;
	}

	</style>

	<div id="box">
		
		<form method="post">
			<div style="font-size: 20px;margin: 10px;color: white;">Signup</div>

			<label for="fname">Username:</label>
			<input id="text" type="text" name="user_name"  pattern="^[a-zA-Z0-9!@#$%^&*()_+]+$"><br><br>

			<label for="fname">Password:</label>
			<input id="text" type="password" name="password" pattern="^[a-zA-Z0-9!@#$%^&*()_+]+$"><br><br>

			<label for="fname">Address:</label>
			<input id="text" type="text" name="address"><br><br>
			<input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">


			<input id="button" type="submit" value="Sign up"><br><br>

			<a href="login1.php">Click to Login</a><br><br>
		</form>
	</div>
</body>
</html>
