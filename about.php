<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Mobile Phone Store</title>
   
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
       
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }
        h1, h2 {
            color: #333;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            color: #555 !important;
        }
        .mission {
            margin-top: 30px;
        }
        .animated-image {
            max-width: 100%;
            animation: floatAnimation 5s ease infinite alternate;
        }
        @keyframes floatAnimation {
            0% {
                transform: translateY(-20px);
            }
            100% {
                transform: translateY(50px);
            }
        }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>

  
    <div class="container">
        <h1 class="mb-4">About Us</h1>
        <div class="row">
            <div class="col-md-6">
                <p>Welcome to Mobile Phone Store, your ultimate destination for the latest and greatest mobile phones and accessories. We are committed to providing our customers with top-quality products, exceptional service, and unbeatable prices.</p>
                
                <h2 class="mt-5">Our Mission</h2>
                <div class="mission">
                    <p>Our mission is to make cutting-edge technology accessible to everyone. We believe that everyone deserves the best mobile phone experience, whether it's for staying connected with loved ones, boosting productivity, or simply enjoying entertainment on the go.</p>
                    <p>We strive to offer a wide selection of smartphones, tablets, accessories, and more, catering to the diverse needs and preferences of our customers. With a focus on innovation, reliability, and affordability, we aim to exceed your expectations every step of the way.</p>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <img src="images/M.jpg" alt="Mobile Phone Store" class="animated-image">
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
