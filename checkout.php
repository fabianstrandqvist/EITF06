<?php
    require_once 'startsession.php';

    $user_data = check_login($con);

    $con = mysqli_connect('localhost', 'root'); // connect to database
    mysqli_select_db($con, 'shop'); // select database
    $sql = "SELECT * FROM products"; // select all products from database
    $featured = mysqli_query($con, $sql); // query database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="checkout">
    <a href="products.php">Back to Shopping Cart</a><br><br>

    <h1 class="header">Checkout</h1>  

    <table>
        <thead>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </thead>
        <tbody>
        <?php
            $grand_total = 0;
            $cart_query = mysqli_query($con, "SELECT * FROM `cart` WHERE user_id = '" . $user_data['user_id'] . "'"); // query database - im not sure if id will work here just yet
            if(mysqli_num_rows($cart_query) > 0){
                while($fetch_cart = mysqli_fetch_assoc($cart_query)){
        ?>
            <tr>
                <td><img src="<?php echo $fetch_cart["image"]; ?>" height="100" alt=""></td>
                <td><?php echo $fetch_cart["name"]; ?></td>
                <td>$<?php echo number_format($fetch_cart['price']); ?>/-</td>
                <td><?php echo $fetch_cart["quantity"]; ?></td>
                <td>$<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
            </tr>
            
        <?php
            $grand_total += intval(str_replace(',', '', $sub_total));
                };
            };
        ?>
        <tr>
            <td colspan="4">Grand Total :</td>
            <td>$<?php echo number_format($grand_total);?>/-</td>
        </tr>
        </tbody>
    </table>

    <div>
        <label for="transactionId">Transaction ID:</label>
        <input type="text" id="transactionId" placeholder="Enter Transaction ID">
        <button id="fetchButton">Fetch Transaction</button>
    </div>

    <hr class="dashed-line">     

    <div id="receiptContainer">
        <!-- <h2 class="header">Receipt:</h2> -->
        <div id="receiptContent"></div>
    </div>

    <!-- Javascript code for retrieving transaction details -->
    <script src="transaction.js"></script>

    <a href="index.php">Back to Home</a><br><br>

    </div>

</body>
</html>