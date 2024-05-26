<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
        input[type="text"], input[type="password"], input[type="email"] {
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
        <h2>User Registration</h2>
        <?php
        include 'config.php';

        
        function sanitize_input($data) {
            return htmlspecialchars(stripslashes(trim($data)));
        }

       
        $username = $email = $password = $confirm_password = "";
        $username_err = $email_err = $password_err = $confirm_password_err = "";
        $success_msg = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
           
            if (empty($_POST["username"])) {
                $username_err = "Username is required";
            } else {
                $username = sanitize_input($_POST["username"]);
            }

            
            if (empty($_POST["email"])) {
                $email_err = "Email is required";
            } else {
                $email = sanitize_input($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $email_err = "Invalid email format";
                }
            }

           
            if (empty($_POST["password"])) {
                $password_err = "Password is required";
            } else {
                $password = sanitize_input($_POST["password"]);
            }

         
            if (empty($_POST["confirm_password"])) {
                $confirm_password_err = "Please confirm your password";
            } else {
                $confirm_password = sanitize_input($_POST["confirm_password"]);
                if ($password != $confirm_password) {
                    $confirm_password_err = "Passwords do not match";
                }
            }

           
            if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
               
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

               
                $sql = "INSERT INTO users (username, password, email, created_at) VALUES (?, ?, ?, NOW())";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $username, $hashed_password, $email);

                if ($stmt->execute()) {
                    $success_msg = "Registration successful!";
                  
                    $username = $email = $password = $confirm_password = "";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $stmt->close();
            }
        }

        $conn->close();
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="error"><?php echo $username_err; ?></div>
            <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>">

            <div class="error"><?php echo $email_err; ?></div>
            <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">

            <div class="error"><?php echo $password_err; ?></div>
            <input type="password" name="password" placeholder="Password" value="<?php echo $password; ?>">

            <div class="error"><?php echo $confirm_password_err; ?></div>
            <input type="password" name="confirm_password" placeholder="Confirm Password" value="<?php echo $confirm_password; ?>">

            <div class="success"><?php echo $success_msg; ?></div>
            <input type="submit" value="Register">
        </form>
        <br>
        <a href="user_login.php">Login From Here !</a>
    </div>

    
</body>
</html>
