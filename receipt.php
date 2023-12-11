<?php
    require_once 'startsession.php';

     // CSRF token generation
     $csrfToken = $_SESSION['csrf_token'];

    $user_data = check_login($con);

    $con = mysqli_connect('localhost', 'root'); // connect to database
    mysqli_select_db($con, 'shop'); // select database
    $sql = "SELECT * FROM products"; // select all products from database
    $featured = mysqli_query($con, $sql); // query database
    
    if (isset($_GET['delete_all'])){
        // Verify CSRF token
        if (!isset($_GET['csrf_token']) || $_GET['csrf_token'] !== $_SESSION['csrf_token']) {
            die("CSRF token validation failed.");
        }
        mysqli_query($con, "DELETE FROM `cart` WHERE user_id = '" . $user_data['user_id'] . "'");
        header('location:index.php');
    }

    $transactionId = isset($_GET['transactionId']) ? $_GET['transactionId'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <div class="receipt">

        <h1 class="header">Receipt</h1>  

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

        <hr class="dashed-line">    

        <h2> Transaction Details: </h2>
        <div id="receiptContainer">
            <div id="receiptContent"></div>
        </div>

        <div id="transactionId" data-transaction-id="<?php echo $transactionId; ?>"></div>

        <script src="receipt.js"></script>

        <!-- deletes cart after transaction -->
        <a href="products.php?delete_all&csrf_token=<?php echo $csrfToken; ?>" class="btn-red">Finish Transaction</a>

    </div>

</body>
</html>