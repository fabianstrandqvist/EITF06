<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'startsession.php';

	$user_data = check_login($con);

    // CSRF token generation
    $csrfToken = $_SESSION['csrf_token'];

    
    $con = mysqli_connect('localhost', 'root'); // connect to database
    mysqli_select_db($con, 'shop'); // select database
    $sql = "SELECT * FROM products WHERE featured=1"; // select all products from database
    $featured = mysqli_query($con, $sql); // query database

    if (isset($_POST['comment'])) {
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF token validation failed.");
        }
        $message = $_POST['message'];

        $sqlcomment = "INSERT INTO comments (uid, message) VALUES ('" . $user_data['user_id'] . "', '$message')";
        mysqli_query($con, $sqlcomment);

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container-fluid" style="padding-left:10px; padding-bottom:10px; padding-top:10px">
        <a href="logout1.php">Logout</a>
        <br>
        Hello, <?php echo $user_data['user_name']; ?>
    </div>

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

            <li class="nav-item">
            <a class="nav-link" href="products.php">Shop</a>
            </li>
        </ul>
    
        </div>
    </div>
    </nav>

    <!-- Home Page -->
    <h2 class="text-center" style="padding-top: 20px">Welcome to the Web Shop!</h2>
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
                        <img src="<?= $product["image"]; ?>" alt="<?= $product['title']; ?>" class="img-fluid pb-4"/>
                        <p class="price">$<?= $product['price']; ?> </p>
                    </div>
                <?php endwhile; ?>
                <a href="products.php">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#details-1">View All Products</button>
                </a>
            </div>
            <hr class="dashed-line">     
            <form method='POST' action=''>
                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                <input type='hidden' name='uid' value='Anonymous'>
                <textarea name='message'></textarea><br><br>
                <input type="submit" value="Review Our Website" name="comment" class="btn btn-success">
            </form>

            <tbody>
                <?php
                    
                    $comment_query = mysqli_query($con, "SELECT * FROM `comments`");
                    if(mysqli_num_rows($comment_query) > 0){
                        while($fetch_comments = mysqli_fetch_assoc($comment_query)){
                ?>
                    <tr>
                        <td style="width:200px"><?php echo $fetch_comments["message"]; ?></td><br>
                    </tr>
                    <?php
                    };
                };
                    ?>
                    </tbody>
                
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> <link rel="stylesheet" href="styles..css">

</body>
</html>