<?php
session_start();



include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_status'])) {
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("UPDATE orders SET status=? WHERE order_id=?");
        $stmt->bind_param("si", $status, $order_id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_order'])) {
        $order_id = $_POST['order_id'];

        // Delete associated order items first due to foreign key constraints
        $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id=?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();

        // Delete the order
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id=?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    
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
<?php include 'admin_header.php'; ?>

    <div class="container">
        <h2 class="mb-4">Manage Orders</h2>
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
                        <th>Actions</th>
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
                            echo "<td>";
                            echo '<form method="POST" action="" style="display:inline;">';
                            echo '<input type="hidden" name="order_id" value="' . $row["order_id"] . '">';
                            echo '<select name="status" class="form-control">';
                            echo '<option value="Pending"' . ($row["status"] == "Pending" ? ' selected' : '') . '>Pending</option>';
                            echo '<option value="On the Way"' . ($row["status"] == "On the Way" ? ' selected' : '') . '>On the Way</option>';
                            echo '<option value="Delivered"' . ($row["status"] == "Delivered" ? ' selected' : '') . '>Delivered</option>';
                            echo '</select>';
                            echo '<button type="submit" name="update_status" class="btn btn-primary mt-2">Update</button>';
                            echo '</form>';
                            echo ' <form method="POST" action="" style="display:inline;">';
                            echo '<input type="hidden" name="order_id" value="' . $row["order_id"] . '">';
                            echo '<button type="submit" name="delete_order" class="btn btn-danger mt-2" onclick="return confirm(\'Are you sure you want to delete this order?\')">Delete</button>';
                            echo '</form>';
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No orders found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
