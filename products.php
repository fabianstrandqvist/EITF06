<?php

require_once 'startsession.php';

// CSRF token generation
$csrfToken = $_SESSION['csrf_token'];

    $user_data = check_login($con);

    $con = mysqli_connect('localhost', 'root'); // connect to database
    mysqli_select_db($con, 'shop'); // select database
    $sql = "SELECT * FROM products"; // select all products from database
    $featured = mysqli_query($con, $sql); // query database
    // $featured = $con->query($sql); // other way to query database

    if (isset($_POST['add_to_cart'])) {
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF token validation failed.");
        }
        // Validate and sanitize user input
        $product_name = mysqli_real_escape_string($con, $_POST['product_name']);
        $product_price = mysqli_real_escape_string($con, $_POST['product_price']);
        $product_image = mysqli_real_escape_string($con, $_POST['product_image']);
        $product_quantity = mysqli_real_escape_string($con, $_POST['product_quantity']);
        $xsssafe_product_quantity = htmlspecialchars($product_quantity, ENT_QUOTES, 'UTF-8');
    
        $select_cart = mysqli_query($con, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '" . $user_data['user_id'] . "'");
    
        if (mysqli_num_rows($select_cart) > 0) {
            // $message = 'Product already added to cart';
            $temp_quantity = mysqli_fetch_assoc($select_cart)['quantity']; // get current quantity
            $new_quantity = $xsssafe_product_quantity + $temp_quantity; // add inputted quantity to current quantity
            mysqli_query($con, "UPDATE `cart`SET quantity = '$new_quantity' WHERE name = '$product_name'");
        } else {
            mysqli_query($con, "INSERT INTO `cart` (user_id, name, price, image, quantity) VALUES 
            ('" . $user_data['user_id'] . "', '$product_name', '$product_price', '$product_image', '$product_quantity')");
            $message = 'Product added to cart successfully';
        }
    }

    if (isset($_POST['update_cart'])){
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF token validation failed.");
        }
        $update_quantity = $_POST['cart_quantity'];
        $update_id = $_POST['cart_id'];
        mysqli_query($con, "UPDATE `cart`SET quantity = '$update_quantity' WHERE id = '$update_id'");
        $message = 'Cart updated!';
    }

    if (isset($_GET['remove'])){ //dangerous! attacker can use a URL to remove cart item from user lol
        // Verify CSRF token
        if (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF token validation failed.");
        }
        $remove_id = $_GET['remove'];
        mysqli_query($con, "DELETE FROM `cart` WHERE id = '$remove_id'");
        header('location:products.php');
    }

    if (isset($_GET['delete_all'])){
        // Verify CSRF token
        if (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF token validation failed.");
        }
        mysqli_query($con, "DELETE FROM `cart` WHERE user_id = '" . $user_data['user_id'] . "'");
        header('location:products.php');
    }


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
                <h2 class="text-center" style="padding-top: 20px">All Products</h2>
                <?php
                    while($fetch_product = mysqli_fetch_assoc($featured)):
                    // TODO: change this to all products not just featured?
                ?>
                    <form method="post" class="col-md-5" action="">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                        <!-- php to display fetch_product title, image, price -->
                        <h4> <?= $fetch_product['title']; ?> </h4> 
                        <img src="<?= $fetch_product["image"]; ?>" alt="<?= $fetch_product['title']; ?>" class="img-fluid pb-4" style="width:250px; height:200px; object-fit:cover;"/>
                        <p class="price">$<?= number_format($fetch_product['price']); ?> </p>
                        <p class="desc"><?= $fetch_product['description']; ?> </p>
                        <p class="bname"><?= $fetch_product['brandname']; ?> </p>
                        <input type="number" min="1" name="product_quantity" value="1">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product["image"]; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product["title"]; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product["price"]; ?>">
                        <input type="submit" value="Add To Cart" style="border: 2px solid black; background:lightgreen" name="add_to_cart" class="btn">
                    </form>
                    
                    <!-- Form for adding item to cart - DELETED -->
                    
                <?php endwhile; ?>
            </div>
        </div>

        <div class="shopping-cart" style="padding-left:50px">
            <h1 class="header" style="padding-top:50px">Shopping Cart</h1>  
            
            <table>
                <thead>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </thead>
                <tbody style="padding-left:50px">
                <?php
                    $grand_total = 0;
                    $cart_query = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '" . $user_data['user_id'] . "'"); // query database - im not sure if id will work here just yet
                    if(mysqli_num_rows($cart_query) > 0){
                        while($fetch_cart = mysqli_fetch_assoc($cart_query)){
                ?>
                    <tr>
                        <td style="width:170px"><img src="<?php echo $fetch_cart["image"]; ?>" height="100" alt=""></td>
                        <td style="width:125px"><?php echo $fetch_cart["name"]; ?></td>
                        <td style="width:100px">$<?php echo number_format($fetch_cart['price']); ?>/-</td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                                <input type="submit" name="update_cart" style="border: 2px solid black; width:100px" value="Update" class="btn">
                            </form>
                        </td>
                        <td style="width:150px; padding-left:10px">$<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
                        <td>
                            <a href="products.php?remove=<?php echo $fetch_cart['id']; ?>&csrf_token=<?php echo $csrfToken; ?>" class="btn" style="border: 2px solid black; width:100px; background:red" onclick="return confirm('Remove Item From Cart?');">Remove</a>
                        </td>
                    </tr>
                    
                <?php
                    $grand_total += intval(str_replace(',', '', $sub_total));
                        };
                    };
                ?>
                <tr style="height:75px">
                    <td colspan="4">Grand Total :</td>
                    <td>$<?php echo number_format($grand_total);?>/-</td>
                    <td><a href="products.php?delete_all&csrf_token=<?php echo $csrfToken; ?>" onclick="return confirm('Delete All From Cart?');" style="border: 2px solid black; width:100px; background:red" class="btn">Delete All</a></td>
                </tr>
                </tbody>
            </table>
        </div>

        <a href="checkout.php" style="padding-left:800px; padding-bottom:50px; padding-top:150px"><button style="border: 2px solid black; border-radius: 10px; background:lightgreen; padding:15px">Proceed to Payment</button></a>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>    <link rel="stylesheet" href="css/style.css">

</body>
</html>