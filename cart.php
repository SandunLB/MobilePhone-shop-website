<?php
session_start();

include "config.php";
include 'includes/header.php'; 


function getProductDetailsFromCart($product_id) {
    global $conn;
    $sql = "SELECT p.name, p.price, c.quantity FROM products p JOIN cart c ON p.product_id = c.product_id WHERE c.product_id = $product_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}


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


if(isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];
    $sql = "DELETE FROM cart WHERE product_id = $product_id";
    if ($conn->query($sql) === TRUE) {
     
    } else {
        echo "Error removing product: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
   
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
     
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header{
            display: flex !important;
        }
        .container {
            margin-top: 200px;
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
  
  

    <div class="container">
        <h2 class="mb-4">Shopping Cart</h2>
        <?php
        $sql = "SELECT c.product_id, c.quantity FROM cart c";
        $result = $conn->query($sql);
        if ($result->num_rows > 0):
        ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
               
                <tbody>
                    <?php
                    while($row = $result->fetch_assoc()):
                       
                        $product_details = getProductDetailsFromCart($row['product_id']);
                        ?>
                        <tr>
                            <td><?php echo $product_details['name']; ?></td>
                            <td>Rs.<?php echo $product_details['price']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td>Rs.<?php echo $product_details['price'] * $row['quantity']; ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" name="remove_product">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="3"><strong>Total:</strong></td>
                        <td colspan="2"><strong>Rs.<?php echo calculateTotalPrice(); ?></strong></td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php

$conn->close();
?>
