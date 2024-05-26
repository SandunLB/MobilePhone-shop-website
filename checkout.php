<?php
session_start();

include "config.php";
include 'includes/header.php';

// Function to calculate total price of items in the cart
function calculateTotalPrice() {
    global $conn;
    $total_price = 0;
    $sql = "SELECT p.price, c.quantity FROM products p JOIN cart c ON p.product_id = c.product_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $total_price += $row['price'] * $row['quantity'];
        }
    }
    return $total_price;
}


if(isset($_POST['place_order'])) {
    $total = calculateTotalPrice();
    $user_id = 1;
    $sql = "INSERT INTO orders (user_id, total) VALUES ($user_id, $total)";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id; 
        
        $cart_items_sql = "SELECT product_id, quantity FROM cart";
        $cart_items_result = $conn->query($cart_items_sql);
        if ($cart_items_result->num_rows > 0) {
            while($cart_row = $cart_items_result->fetch_assoc()) {
                $product_id = $cart_row['product_id'];
                $quantity = $cart_row['quantity'];
                $product_details_sql = "SELECT price FROM products WHERE product_id = $product_id";
                $product_details_result = $conn->query($product_details_sql);
                if ($product_details_result->num_rows > 0) {
                    $product_row = $product_details_result->fetch_assoc();
                    $price = $product_row['price'];
                    
                    $insert_order_item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $price)";
                    $conn->query($insert_order_item_sql);
                }
            }
            
            $clear_cart_sql = "DELETE FROM cart";
            $conn->query($clear_cart_sql);
           
            header("Location: order_success.php");
            exit();
        }
    } else {
        echo "Error placing order: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>

        header {
            display: flex !important;
        }
       
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
           
        }
        .container {
            padding: 20px;
            margin-top: 200px;
        }
    </style>
</head>
<body>
    
   

   
    <div class="container">
        <h2 class="mb-4">Checkout</h2>
        <div class="row">
            <div class="col-md-6">
                <h4>Order Summary</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT p.name, c.quantity, p.price FROM products p JOIN cart c ON p.product_id = c.product_id";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['quantity'] . "</td>";
                                echo "<td>Rs." . $row['price'] * $row['quantity'] . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><strong>Total:</strong></td>
                            <td><strong>Rs.<?php echo calculateTotalPrice(); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-6">
                
                <h4>Payment Details</h4>
                <form method="post">
                    <div class="form-group">
                        <label for="card_number">Card Number:</label>
                        <input type="text" class="form-control" id="card_number" name="card_number" required>
                    </div>
                    <div class="form-group">
                        <label for="expiry_date">Expiry Date:</label>
                        <input type="text" class="form-control" id="expiry_date" name="expiry_date" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV:</label>
                        <input type="text" class="form-control" id="cvv" name="cvv" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="place_order">Place Order</button>
                </form>
            </div>
        </div>
    </div>

  
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php

$conn->close();
?>
