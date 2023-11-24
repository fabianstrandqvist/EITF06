<?php 
session_start();

	include("connection1.php");
	include("functions1.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];

		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);

		$valid = $uppercase && $lowercase && $number && strlen($password) >= 8;

		if(!empty($user_name) && !empty($password) && !is_numeric($user_name) && $valid)
		{

			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			//save to database
			$user_id = random_num(20);
			$query = "insert into users (user_id,user_name,password) values ('$user_id','$user_name','$hashed_password')";

			mysqli_query($con, $query);

			header("Location: login1.php");
			die;
		}else
		{
			echo "Password must be atleast 8 characters long, contain atleast an uppcase character
			and one number";
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

			<input id="text" type="text" name="user_name"  pattern="^[a-zA-Z0-9!@#$%^&*()_+]+$"><br><br>
			<input id="text" type="password" name="password" pattern="^[a-zA-Z0-9!@#$%^&*()_+]+$"><br><br>

			<input id="button" type="submit" value="Signup"><br><br>

			<a href="login1.php">Click to Login</a><br><br>
		</form>
	</div>
</body>
</html>
