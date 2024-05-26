<?php

session_start();


if (!isset($_SESSION['user_id'])) {
   
    header("Location: user_login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Items</title>
  
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>
    <div class="container">
        <h1 class="text-center my-4">Category Items</h1>
        <div class="row">
            <?php
            include 'config.php';

            
            $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

          
            $sql = "SELECT name, description FROM categories WHERE category_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $category_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $category = $result->fetch_assoc();

            if ($category) {
                echo '
                <div class="col-12 mb-4">
                    <h2>' . $category["name"] . '</h2>
                    <p>' . $category["description"] . '</p>
                </div>
                ';

              
                $sql = "SELECT name, description, price, image FROM products WHERE category_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $category_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '
                        <div class="col-md-4">
                            <div class="card">
                                <img src="uploads/' . $row["image"] . '" class="card-img-top" alt="' . $row["name"] . '">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row["name"] . '</h5>
                                    <p class="card-text">' . $row["description"] . '</p>
                                    <p class="card-text"><strong>Price:</strong> Rs.' . $row["price"] . '</p>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                } else {
                    echo '<p>No products available in this category.</p>';
                }
            } else {
                echo '<p>Category not found.</p>';
            }

           
            $conn->close();
            ?>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
