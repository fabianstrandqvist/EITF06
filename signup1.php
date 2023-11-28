<?php 

require_once 'startsession.php';


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		$address = $_POST['address'];

		$sanitized_user_name = mysqli_real_escape_string($con, $user_name);
		$sanitized_password = mysqli_real_escape_string($con, $password);
		$sanitized_address = mysqli_real_escape_string($con, $address);	

		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);

		$valid = $uppercase && $lowercase && $number && strlen($password) >= 8;

		if(!empty($sanitized_user_name) && !empty($sanitized_password) && !empty($sanitized_address) && !is_numeric($user_name) && $valid)
		{

			$hashed_password = password_hash($sanitized_password, PASSWORD_DEFAULT);
			//save to database
			$user_id = random_num(20);
			$query = "insert into users (user_id,user_name,password,address) values ('" . $user_id . "','" . $sanitized_user_name . "','" . $hashed_password . "', '" . $sanitized_address . "')";

			mysqli_query($con, $query);

			header("Location: login1.php");
			die;
		}else
		{
			echo "Password must be at least 8 characters long, contain at least one upper case character,
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
			<input id="text" type="address" name="address"><br><br>

			<input id="button" type="submit" value="Signup"><br><br>

			<a href="login1.php">Click to Login</a><br><br>
		</form>
	</div>
</body>
</html>
