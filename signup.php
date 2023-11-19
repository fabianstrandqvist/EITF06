<?php
    $con = mysqli_connect('localhost', 'root');

    // Check if connection is successful
    if($con){
        echo "Connection Successful";
    }
    else {
        echo "Connection Failed";
    }

    mysqli_select_db($con, 'webshop'); // Select database

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Insert data into database
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    mysqli_query($con, $query); // Check connection working
    header('location:index.php#signupform'); // Redirect to index.php after submitting the form
?>