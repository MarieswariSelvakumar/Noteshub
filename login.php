<?php
session_start();
include "db.php";
$message = "";

// If already logged in → redirect
if (isset($_SESSION["user_id"])) {
    if ($_SESSION["username"] === "admin") {
        header("Location: admin_home.php");
    } else {
        header("Location: home.php");
    }
    exit;
}

// Handle login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        // Redirect based on role
        if ($user["username"] === "admin") {
            header("Location: admin_home.php");
        } else {
            header("Location: home.php");
        }
        exit;
    } else {
        $message = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <style>
        body, html { margin:0; padding:0; height:100%; font-family:'Segoe UI', sans-serif; }

        /* Light Blue + White Gradient */
        body {
            background: linear-gradient(135deg, #E0F7FA, #ffffff);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 380px;
            padding: 40px 30px;
            border-radius: 20px;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            text-align: center;
            color: #0277BD;
        }

        h2 { font-size: 32px; margin-bottom: 25px; color: #0277BD; }

        input[type=text], input[type=password] {
            width: 100%; padding: 14px; margin: 12px 0;
            border-radius: 12px; border: 1px solid #B3E5FC;
            background: rgba(255,255,255,0.85); color: #0277BD;
            font-size: 16px;
        }
        input[type=text]:focus, input[type=password]:focus {
            border: 1px solid #03A9F4;
            box-shadow: 0 0 8px rgba(3,169,244,0.4);
        }

        /* Fancy login button with ripple */
        input[type=submit] {
            width: 100%; padding: 15px; margin-top: 20px;
            border: none; border-radius: 12px;
            background: #03A9F4; color: #fff;
            font-weight: bold; font-size: 18px;
            cursor: pointer; position: relative; overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        input[type=submit]:hover {
            background: #0288D1;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        input[type=submit]::after {
            content: "";
            position: absolute;
            background: rgba(255,255,255,0.4);
            border-radius: 50%;
            width: 100px;
            height: 100px;
            top: 50%;
            left: 50%;
            pointer-events: none;
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
            transition: transform 0.6s, opacity 0.8s;
        }
        input[type=submit]:active::after {
            transform: translate(-50%, -50%) scale(2.5);
            opacity: 0;
            transition: 0s;
        }

        .message { color: #D32F2F; margin-top: 15px; font-weight: bold; }

        /* Fancy links/buttons */
        .links {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        .links a {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 10px;
            background: #03A9F4;
            color: #fff;
            font-weight: bold;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .links a:hover {
            background: #0288D1;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        .links a::after {
            content: "";
            position: absolute;
            background: rgba(255,255,255,0.4);
            border-radius: 50%;
            width: 100px;
            height: 100px;
            top: 50%;
            left: 50%;
            pointer-events: none;
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
            transition: transform 0.6s, opacity 0.8s;
        }
        .links a:active::after {
            transform: translate(-50%, -50%) scale(2.5);
            opacity: 0;
            transition: 0s;
        }

        p { margin-top: 15px; font-size: 14px; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post">
        <input type="text" name="username" placeholder="Username" required autocomplete="off">
<input type="password" name="password" placeholder="Password" required autocomplete="current-password">
            <input type="submit" value="Login">
        </form>
        <p class="message"><?= $message ?></p>
        <p>No account? <a href="register.php">Register here</a></p>
    </div>

    <!-- Extra buttons below the login box -->
    <div class="links">
        <a href="index.php">🏠 Back to Homepage</a>
        <a href="admin_login.php">🔑 Admin Login</a>
    </div>
</body>
</html>
