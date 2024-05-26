<?php

session_start();


if (!isset($_SESSION['user_id'])) {
    
    header("Location: user_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_cart"])) {
    $productId = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    include 'config.php';

    
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $userId = $_SESSION['user_id']; 
    $stmt->bind_param("iii", $userId, $productId, $quantity);
    $stmt->execute();

    
    $stmt->close();
    $conn->close();

    
    header("Location: ".$_SERVER['PHP_SELF']); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
            margin-top: 100px;
        }
        .card {
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>
    
    
    <div class="container">
        <h2 class="mb-4">Products</h2>
        <div class="row">
            <div class="col-md-3">
                
                <div class="form-group">
                    <label for="categorySelect">Select Category:</label>
                    <select class="form-control" id="categorySelect">
                        <option value="">All Categories</option>
                        <?php
                            include 'config.php';

                        
                        $sql = "SELECT category_id, name FROM categories";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row["category_id"] . '">' . $row["name"] . '</option>';
                            }
                        } else {
                            echo '<option value="">No categories found</option>';
                        }

                        
                        $conn->close();
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-9">
              
                <div class="row" id="productsContainer">
                    <?php
                   
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "mobile_store"; 

                 
                    $conn = new mysqli($servername, $username, $password, $dbname);

                   
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    
                    $sql = "SELECT p.product_id, p.name AS product_name, p.description AS product_description, p.price, p.image, p.category_id, c.name AS category_name 
                            FROM products p 
                            LEFT JOIN categories c ON p.category_id = c.category_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '
                            <div class="col-md-4" data-category-id="' . $row["category_id"] . '">
                                <div class="card">
                                    <img src="uploads/' . $row["image"] . '" class="card-img-top" alt="' . $row["product_name"] . '">
                                    <div class="card-body">
                                        <h5 class="card-title">' . $row["product_name"] . '</h5>
                                        <p class="card-text">' . $row["product_description"] . '</p>
                                        <p class="card-text"> Rs.' . $row["price"] . '</p>
                                        <p class="card-text"> ' . $row["category_name"] . '</p>
                                        <form method="POST" action="">
                                            <div class="form-group">
                                                <label for="quantity_' . $row["product_id"] . '">Quantity:</label>
                                                <input type="number" class="form-control" id="quantity_' . $row["product_id"] . '" name="quantity" value="1" min="1">
                                            </div>
                                            <input type="hidden" name="product_id" value="' . $row["product_id"] . '">
                                            <button type="submit" class="btn btn-primary" name="add_to_cart">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                    } else {
                        echo '<p>No products found</p>';
                    }

                 
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
     
        document.getElementById('categorySelect').addEventListener('change', function() {
            var categoryId = this.value;
            var products = document.querySelectorAll('#productsContainer .col-md-4');
            products.forEach(function(product) {
                var productCategoryId = product.getAttribute('data-category-id');
                if (categoryId === '' || productCategoryId === categoryId) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });
    </script>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
