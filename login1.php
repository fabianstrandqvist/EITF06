<?php

require_once 'startsession.php';

// Command to test for invalid tokens: curl -X POST -d "user_name=test&password=test&csrf_token=invalid_token" localhost/EITF06/signup1.php
// CSRF token generation
$csrfToken = $_SESSION['csrf_token'];

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed.");
    }
    //something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    $sanitized_user_name = mysqli_real_escape_string($con, $user_name);
    $sanitized_password = mysqli_real_escape_string($con, $password);

    if(!empty($sanitized_user_name) && !empty($sanitized_password) && !is_numeric($sanitized_user_name))
    {

        // Read from database using prepared statement and bound parameter
        $query = "SELECT * FROM users WHERE user_name = ? LIMIT 1";

        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $sanitized_user_name);
        $stmt->execute();
        $result = $stmt->get_result();

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
    <link rel="stylesheet" type="text/css" href="log_sign.css">
    <title>Login</title>
</head>
<body>
    <div id="box">
        <form method="post">
            <div style="font-size: 20px;margin: 10px;color: white;">Login</div>

            <label for="fname">Username:</label>
            <input type="text" name="user_name" pattern="^[a-zA-Z0-9!@#$%^&*()_+]+$"><br><br>

            <label for="fname">Password:</label>
            <input type="password" name="password" pattern="^[a-zA-Z0-9!@#$%^&*()_+]+$"><br><br>

            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
            <input id="button" type="submit" value="Login"><br><br>

            <a href="signup1.php">Click to Signup</a><br><br>
    
</body>
</html>
