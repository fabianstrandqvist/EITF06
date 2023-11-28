<?php

require_once 'startsession.php';


if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
    {

        //read from database
        $query = "select * from users where user_name = '$user_name' limit 1";

        $result = mysqli_query($con, $query);

        if($result)
        {
            if($result && mysqli_num_rows($result) > 0)
            {
                $user_data = mysqli_fetch_assoc($result);
                
                if(password_verify($password, $user_data['password'])){

                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: index.php");
                    die;
                }
            }
        }

        echo "Wrong username or password";
    }else
    {
        echo "Please enter some valid information!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
   
    <title>Login</title>
</head>
<body>
    <style>
    </style>

    <div id="box">
        <form method="post">
            <div>Login</div>

            <label for="fname">Username:</label>
            <input type="text" name="user_name" pattern="^[a-zA-Z0-9!@#$%^&*()_+]+$"><br><br>

            <label for="fname">Password:</label>
            <input type="text" name="password" pattern="^[a-zA-Z0-9!@#$%^&*()_+]+$"><br><br>

            <input type="submit" value="Login"><br><br>

            <a href="signup1.php">Click to Signup</a><br><br>
    
</body>
</html>