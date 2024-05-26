
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Advanced Admin Header</title>
<style>

body, h1, ul {
  margin: 0;
  padding: 0;
}


header {
  background: linear-gradient(to right, #3f51b5, #2196f3);
  color: #fff;
  padding: 10px 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  display: flex;
  align-items: center;
  justify-content: space-between;
}


.logo {
  font-size: 24px;
  font-weight: bold;
}


.nav {
  list-style-type: none;
}

.nav li {
  display: inline-block;
  margin-right: 20px;
}

.nav li a {
  color: #fff;
  text-decoration: none;
  transition: color 0.3s ease;
}

.nav li a:hover {
  color: #ffc107;
}


.avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  overflow: hidden;
  border: 2px solid #fff;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
  transition: box-shadow 0.3s ease;
}

.avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.avatar:hover {
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}


.actions {
  display: flex;
  align-items: center;
}

.actions button {
  background-color: transparent;
  color: #fff;
  border: none;
  padding: 8px 12px;
  margin-left: 10px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.actions button:hover {
  background-color: rgba(255, 255, 255, 0.1);
}
</style>
</head>
<body>

<header>
  <div class="logo">Admin Panel</div>
  <nav class="nav">
    <ul>
      <li><a href="admin_dashboard.php">Dashboard</a></li>
      <li><a href="admin_category.php">Categories</a></li>
      <li><a href="admin_products.php">Products</a></li>
      <li><a href="admin_services.php">Services</a></li>
      <li><a href="admin_orders.php">Orders</a></li>

     
      
     
    </ul>
  </nav>
  <div class="actions">
    <div class="avatar">
      <img src="../images/icons8-avatar-96.png" alt="User Avatar">
    </div>
    
    <a href="admin_logout.php"><button>Logout</button></a>
  </div>
</header>


</body>
</html>
