<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .success {
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Login</h2>
        <?php
        
        include 'config.php';

      
        function sanitize_input($data) {
            return htmlspecialchars(stripslashes(trim($data)));
        }

      
        $username = $password = "";
        $username_err = $password_err = $login_err = "";
        $success_msg = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
         
            if (empty($_POST["username"])) {
                $username_err = "Username is required";
            } else {
                $username = sanitize_input($_POST["username"]);
            }

            
            if (empty($_POST["password"])) {
                $password_err = "Password is required";
            } else {
                $password = sanitize_input($_POST["password"]);
            }

            
            if (empty($username_err) && empty($password_err)) {
               
                $sql = "SELECT user_id, username, password FROM users WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($user_id, $username, $hashed_password);
                    $stmt->fetch();

                    if (password_verify($password, $hashed_password)) {
                        
                        session_start();
                        $_SESSION["user_id"] = $user_id;
                        $_SESSION["username"] = $username;
                        $success_msg = "Login successful!";
                       
                        header("location: home.php");
                    } else {
                        $login_err = "Invalid username or password.";
                    }
                } else {
                    $login_err = "Invalid username or password.";
                }

                $stmt->close();
            }
        }

        $conn->close();
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="error"><?php echo $username_err; ?></div>
            <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>">

            <div class="error"><?php echo $password_err; ?></div>
            <input type="password" name="password" placeholder="Password" value="<?php echo $password; ?>">

            <div class="error"><?php echo $login_err; ?></div>
            <div class="success"><?php echo $success_msg; ?></div>
            <input type="submit" value="Login">
        </form>
<br>

        <a href="user_registration.php">Register from Here !</a>
    </div>

</body>
</html>
