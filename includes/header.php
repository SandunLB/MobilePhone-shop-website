<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <style>
        /* Reset some default styles */
        body, h1, h2, h3, p, ul, li {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
        }
        
        /* Header styles */
        header {
            background-color: rgba(51, 51, 51, 0.5); /* Transparent background color */
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000; /* Ensure the header appears above other content */
            backdrop-filter: blur(10px); /* Apply blur effect */
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
        }
        .nav-links ul {
            list-style-type: none;
            display: flex;
        }
        .nav-links li {
            margin-right: 20px;
        }
        .nav-links a {
            text-decoration: none;
            color: #fff;
        }
        .cart {
            display: flex;
            align-items: center;
        }
        .cart-icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }
        .profile-info {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }
        .profile-info img {
            width: 30px; /* Adjust the size of the profile image */
            border-radius: 50%; /* Make the image round */
            margin-right: 5px;
        }
        /* Example hover effect */
        .nav-links a:hover {
            color: #ffd700; /* Change color on hover */
        }
        /* Responsive styles */
        @media screen and (max-width: 768px) {
            .nav-links {
                display: none; /* Hide navigation links on small screens */
            }
        }
    </style>
</head>
<body>
    <header>
        <!-- Logo -->
        <a href="#" class="logo">CodeMobile</a>
        <!-- Navigation Links -->
        <nav class="nav-links">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="view_orders.php">View Orders</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <?php if(isset($_SESSION["user_id"])): ?>
          
            <div class="profile-info">
                <img src="images/icons8-avatar-96.png" alt="User Image">
                <span><?php echo $_SESSION["username"]; ?></span>
                <a href="logout.php">Logout</a>
            </div>
            
        <?php else: ?>
            
            <div class="login-links">
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </div>
        <?php endif; ?>
        <div class="cart">
            <a href="cart.php"><i class="fas fa-shopping-cart cart-icon"></i></a>
            <span id="cart-count">0</span> 
        </div>
    </header>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetchCartCount();

            function fetchCartCount() {
                fetch('get_cart_count.php')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('cart-count').textContent = data.count;
                    })
                    .catch(error => {
                        console.error('Error fetching cart count:', error);
                    });
            }
        });
    </script>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
