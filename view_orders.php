<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: user_login.php"); 
    exit();
}

include "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 100px;
            padding: 20px;
        }
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>

 
    <div class="container">
        <h2 class="mb-4">View Orders</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Total Amount</th>
                        <th>Order Date</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT o.order_id, o.total, o.created_at, u.username AS customer_name, u.email, p.name AS product_name, p.price, oi.quantity, o.status
                            FROM orders o
                            JOIN users u ON o.user_id = u.user_id
                            JOIN order_items oi ON o.order_id = oi.order_id
                            JOIN products p ON oi.product_id = p.product_id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["order_id"] . "</td>";
                            echo "<td>$" . $row["total"] . "</td>";
                            echo "<td>" . $row["created_at"] . "</td>";
                            echo "<td>" . $row["customer_name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["product_name"] . "</td>";
                            echo "<td>$" . $row["price"] . "</td>";
                            echo "<td>" . $row["quantity"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No orders found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

  
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include 'includes/footer.php'; ?>
</body>
</html>

<?php

$conn->close();
?>
