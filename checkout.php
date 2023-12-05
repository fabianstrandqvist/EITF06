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
</head>
<body>
    <a href="products.php">Back to Shopping Cart</a><br><br>

    <h1 class="header" style="padding-left:50px">Checkout</h1>  

    <table style="padding-left:50px">
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
                <td style="width:170px"><img src="<?php echo $fetch_cart["image"]; ?>" height="100" alt=""></td>
                <td style="width:125px"><?php echo $fetch_cart["name"]; ?></td>
                <td style="width:100px">$<?php echo number_format($fetch_cart['price']); ?>/-</td>
                <td style="width:50px"><?php echo $fetch_cart["quantity"]; ?></td>
                <td style="width:150px; padding-left:10px">$<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
            </tr>
            
        <?php
            $grand_total += intval(str_replace(',', '', $sub_total));
                };
            };
        ?>
        <tr style="height:75px">
            <td colspan="4">Grand Total :</td>
            <td>$<?php echo number_format($grand_total);?>/-</td>
        </tr>
        </tbody>
    </table>
        
    <!-- Button does not do anything yet -->
    <div style="padding-left:650px">
        <input id="button" type="submit" value="Pay Now" style="border: 2px solid black; border-radius: 10px; background:lightgreen; padding:15px"><br><br>
    </div>


    <h2 class="header" style="padding-top:50px; padding-left:50px; color:red">**Add Payment Stuff Here**</h2>  

    <!-- TODO: clear cart after selecting button to pay -->

</body>
</html>