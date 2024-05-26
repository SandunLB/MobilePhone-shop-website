<?php

session_start();


if (!isset($_SESSION['user_id'])) {
    
    header("Location: user_login.php");
    exit;
}


$welcome_message = "Welcome, " . $_SESSION['username'] . "!";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Phone Shop</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            
        }
        p{
            color: #000 !important;
        }
        .landing {
            position: relative;
            height: 100vh;
            background: url('images/abstract-dark-colorful-subtle-4k-xo.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
        }
        .landing h1 {
            font-size: 3rem;
            animation: fadeInDown 2s;
        }
        .landing p {
            font-size: 1.5rem;
            animation: fadeInUp 2s;
        }
        .section-title {
            margin-top: 40px;
            margin-bottom: 20px;
        }
        .features, .who-we-are {
            padding: 60px 0;
        }
        .features .fa {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #4CAF50;
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
  
    <div class="landing">
        <div>
            <h1 class="animate__animated animate__fadeInDown">Welcome to Our Mobile Phone Shop</h1>
            <p class="animate__animated animate__fadeInUp">Best Phones, Best Services</p>
        </div>
    </div>

    <div class="container">
        
        <section class="who-we-are">
            <h2 class="section-title text-center">Who We Are</h2>
            <p class="text-center">We are a leading mobile phone shop offering the best prices and services in town. Our mission is to provide our customers with high-quality products and exceptional customer service.</p>
        </section>

        
        <section class="features">
            <div class="row text-center">
                <div class="col-md-4">
                    <i class="fas fa-shipping-fast fa-3x"></i>
                    <h3>Fast Shipping</h3>
                    <p>Get your orders delivered to your doorstep in no time with our fast and reliable shipping services.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-headphones-alt fa-3x"></i>
                    <h3>Customer Support</h3>
                    <p>Our customer support team is always here to assist you with any questions or concerns you may have.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-mobile-alt fa-3x"></i>
                    <h3>Wide Selection</h3>
                    <p>We offer a wide selection of the latest mobile phones and accessories at competitive prices.</p>
                </div>
            </div>
        </section>

      
        <section>
            <h2 class="section-title text-center">Our Services</h2>
            <div class="row">
                <?php
                    include 'config.php';
               
                $sql = "SELECT name, description, price, image FROM services";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '
                        <div class="col-md-4">
                            <div class="card">
                                <img src="uploads/services/' . $row["image"] . '" class="card-img-top" alt="' . $row["name"] . '">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row["name"] . '</h5>
                                    <p class="card-text">' . $row["description"] . '</p>
                                    
                                </div>
                            </div>
                        </div>
                        ';
                    }
                } else {
                    echo '<p>No services available.</p>';
                }
                ?>
            </div>
        </section>

      
        <section>
            <h2 class="section-title text-center">Categories</h2>
            <div class="row">
                <?php
                
                $sql = "SELECT category_id, name, description, image FROM categories";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '
                        <div class="col-md-4">
                            <div class="card">
                                <a href="category.php?category_id=' . $row["category_id"] . '">
                                    <img src="uploads/categories/' . $row["image"] . '" class="card-img-top" alt="' . $row["name"] . '">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">' . $row["name"] . '</h5>
                                    <p class="card-text">' . $row["description"] . '</p>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                } else {
                    echo '<p>No categories available.</p>';
                }

                
                $conn->close();
                ?>
            </div>
        </section>
    </div>
    <br><br><br><br><br>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <?php include 'includes/footer.php'; ?>
</body>
</html>
