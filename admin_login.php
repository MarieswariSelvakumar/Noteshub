<?php
session_start();
include "db.php"; // database connection
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    $admin = mysqli_fetch_assoc($result);

    if ($admin) {
        $_SESSION["admin"] = $admin["username"];
        header("Location: admin_panel.php");
        exit;
    } else {
        $message = "Invalid admin login!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<style>
    /* Reset & Base */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #42a5f5, #e3f2fd);
    }

    /* Container */
    .container {
        width: 400px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 40px 30px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .container:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.25);
    }

    /* Heading */
    h2 {
        color: #1565c0;
        font-size: 32px;
        margin-bottom: 30px;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
    }

    /* Inputs */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 10px 0;
        border-radius: 12px;
        border: 1px solid #b3e5fc;
        font-size: 16px;
        outline: none;
        transition: 0.3s;
    }
    input[type=text]:focus, input[type=password]:focus {
        border-color: #1e88e5;
        box-shadow: 0 0 10px rgba(30, 136, 229, 0.3);
    }

    /* Fancy Button */
    input[type=submit] {
        width: 100%;
        padding: 15px;
        margin-top: 20px;
        border: none;
        border-radius: 12px;
        background: linear-gradient(45deg, #1e88e5, #42a5f5);
        color: #fff;
        font-weight: bold;
        font-size: 18px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    input[type=submit]:hover {
        transform: translateY(-3px) scale(1.03);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }
    input[type=submit]:active::after {
        transform: scale(1);
        opacity: 0;
        transition: 0s;
    }
    input[type=submit]::after {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        pointer-events: none;
        background: rgba(255,255,255,0.3);
        border-radius: 12px;
        transform: scale(0);
        transition: transform 0.5s, opacity 1s;
    }

    /* Message */
    .message {
        color: #d32f2f;
        margin-top: 15px;
        font-weight: bold;
    }

    /* Links */
    .links {
        margin-top: 20px;
    }
    .links a {
        display: inline-block;
        margin: 5px;
        padding: 10px 20px;
        background: linear-gradient(45deg, #0288d1, #03a9f4);
        color: #fff;
        border-radius: 10px;
        text-decoration: none;
        font-weight: bold;
        transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
    }
    .links a:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.3);
        background: linear-gradient(45deg, #0277bd, #039be5);
    }

    @media(max-width: 450px){
        .container { width: 90%; padding: 30px 20px; }
    }
</style>
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <p class="message"><?= $message ?></p>
        <div class="links">
            <a href="index.php">Back to Homepage</a>
        </div>
    </div>
</body>
</html>
