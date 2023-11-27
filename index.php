<?php 
session_start();

	include("connection1.php");
	include("functions1.php");

	$user_data = check_login($con);

    
    $con = mysqli_connect('localhost', 'root'); // connect to database
    mysqli_select_db($con, 'shop'); // select database
    $sql = "SELECT * FROM products WHERE featured=1"; // select all products from database
    $featured = mysqli_query($con, $sql); // query database
    // $featured = $con->query($sql); // other way to query database

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel = "stylesheet" href="css/style.css">
</head>
<body>

    <a href="logout1.php">Logout</a>
    <br>
    Hello, <?php echo $user_data['user_name']; ?>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Web Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>

            <!-- <li class="nav-item">
            <a class="nav-link" href="#signupform">Sign Up</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="#">Login In</a>
            </li> -->

            <!-- TODO: implement this button to direct to products.php -->
            <li class="nav-item">
            <a class="nav-link" href="products.php">Shop</a>
            </li>

            <!-- Optional Dropdown -->
            <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Dropdown
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
            </li> -->
        </ul>

        <!-- Search Bar -->
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        </div>
    </div>
    </nav>

    <!-- Home Page -->
    <h2 class="text-center">Welcome to the Web Shop!</h2>
    <div class="col-md-2"> </div>
        <div class="text-center" class="col-md-8">
            <div class="row">
                <h4 class="text-center">Top Products</h4>
        
                <?php
                    while($product = mysqli_fetch_assoc($featured)):
                ?>
                    <div class="col-md-5">
                        <!-- php to display product title, image, price -->
                        <h4> <?= $product['title']; ?> </h4> 
                        <img src="<?= $product["image"]; ?>" alt="<?= $product['title']; ?>" class="img-fluid pb-4" style="width:250px; height:200px; object-fit:cover;"/>
                        <p class="price">$<?= $product['price']; ?> </p>
                    </div>
                <?php endwhile; ?>
                <a href="products.php">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#details-1">View All Products</button>
                </a>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>    <link rel="stylesheet" href="css/style.css">

</body>
</html>