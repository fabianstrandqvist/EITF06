<?php
    $con = mysqli_connect('localhost', 'root'); // connect to database
    mysqli_select_db($con, 'shop'); // select database
    $sql = "SELECT * FROM products"; // select all products from database
    $featured = mysqli_query($con, $sql); // query database
    // $featured = $con->query($sql); // other way to query database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel = "stylesheet" href="css/style.css">
</head>
<body>

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
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
        </ul>

        <!-- Search Bar -->
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        </div>
    </div>
    </nav>

    <div class="col-md-2"> </div>
        <div class="text-center" class="col-md-8">
            <div class="row">
                <h2 class="text-center">All Products</h2>
                <?php
                    while($product = mysqli_fetch_assoc($featured)):
                ?>
                    <div class="col-md-5">
                        <!-- php to display product title, image, price -->
                        <h4> <?= $product['title']; ?> </h4> 
                        <img src="<?= $product["image"]; ?>" alt="<?= $product['title']; ?>" class="img-fluid pb-4" style="width:250px; height:200px; object-fit:cover;"/>
                        <p class="price">$<?= $product['price']; ?> </p>
                        <p class="desc"><?= $product['description']; ?> </p>
                        <p class="bname"><?= $product['brandname']; ?> </p>
                    </div>
                    <!-- TODO: implement button to add item to cart -->
                    <a href="cart.php">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#item-1">Add to Cart</button>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>    <link rel="stylesheet" href="css/style.css">

</body>
</html>