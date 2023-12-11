<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once 'startsession.php';

   

    $con = mysqli_connect('localhost', 'root'); // connect to database
    mysqli_select_db($con, 'shop'); // select database
    $sql = "SELECT * FROM products"; // select all products from database
    $featured = mysqli_query($con, $sql); // query database
    $user_data = check_login($con);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
    <a href="products.php" style="padding-left:30px;">Back to Shopping Cart</a><br><br>

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
                <td style="width:150px; padding-left:50px">$<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
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
        

    <div style="padding-left: 75px; padding-bottom:30px;">
            <label for="transactionId">Transaction ID:</label>
            <input type="text" id="transactionId" placeholder="Enter Transaction ID">
            <button id="fetchButton" style="border: 2px solid black; border-radius: 10px; background: lightgreen; padding: 10px;">Fetch Transaction</button>
        </div>

        <hr class="dashed-line">     

        <div id="receiptContainer" style="padding-left: 50px; padding-top: 20px;">
          <h2 class="header" style="color: green">Receipt:</h2>
            <div id="receiptContent"></div>
        </div>

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
                    <td style="width:150px; padding-left:50px">$<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
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


    <script>
        async function fetchTransaction(transactionId){
            try{
                const response = await fetch(`http://localhost:3000/getTransaction`, {
                     method: 'POST',
                     headers: {
                     'Content-Type': 'application/json',
                    },
                     body: JSON.stringify({ transactionId }),
                });
                const data     = await response.json();
                
                console.log(data);
                displayReceipt(data);
                }   catch (error){
                console.error('Error fetching transaction:', error);
            }
        }
        function displayReceipt(data) {
        const receiptContainer = document.getElementById('receiptContainer');
        const receiptContent = document.getElementById('receiptContent');

        // Clear previous content
        receiptContent.innerHTML = '';

        if (data.error) {
            // Display error message
            receiptContent.innerText = `Error: ${data.error}`;
        } else if (data.transaction) {
            // Display transaction details
            const transaction = data.transaction;
            const transactionHTML = `
                <p>Sender: ${transaction.sender}</p>
                <p>Recipient: ${transaction.recipient}</p>
                <p>Amount: ${transaction.amount}</p>
                <p>Timestamp: ${transaction.timestamp}</p>
                <p>Transaction ID: ${transaction.txidString}</p>`;
            receiptContent.innerHTML = transactionHTML;
        }
    }

        document.getElementById('fetchButton').addEventListener('click', function(){
            const transactionId = document.getElementById('transactionId').value;

            if(transactionId.trim() !== ''){
                fetchTransaction(transactionId);
            } else {
                alert('Please enter a valid Transaction ID.');
            }
        });
    </script>

    <!-- TODO: clear cart after selecting button to pay -->

    <a href="index.php" style="padding-left:30px">Back to Home</a><br><br>


</body>
</html>