<?php
include "db.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Check if username or email already exists
    $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $message = "Username or Email already exists! Try another.";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            $message = "Registration successful! <a href='login.php'>Login here</a>";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        /* Reset & font */
        body, html { margin:0; padding:0; height:100%; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        /* Background: white + light blue gradient */
        body {
            background: linear-gradient(135deg, #E0F7FA, #ffffff);
            display: flex; 
            justify-content: center; 
            align-items: center;
            color: #0277BD;
        }

        /* Glass effect container */
        .container {
            width: 360px;
            padding: 40px 30px;
            border-radius: 20px;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
            color: #0277BD;
        }

        h2 {
            font-size: 32px;
            margin-bottom: 30px;
            color: #0277BD;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
        }

        input[type=text], input[type=email], input[type=password] {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border-radius: 12px;
            border: 1px solid #B3E5FC;
            outline: none;
            font-size: 16px;
            background: rgba(255,255,255,0.8);
            color: #0277BD;
        }

        input::placeholder { color: #555; }

        input[type=text]:focus, input[type=email]:focus, input[type=password]:focus {
            border: 1px solid #03A9F4;
            box-shadow: 0 0 8px rgba(3,169,244,0.4);
        }

        /* Fancy submit button with ripple */
        input[type=submit] {
            width: 100%;
            padding: 15px;
            margin-top: 20px;
            border: none;
            border-radius: 12px;
            background: #03A9F4;
            color: #fff;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
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

        .message {
            color: #D32F2F;
            margin-top: 15px;
            font-weight: bold;
        }

        a {
            color: #0277BD;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }
        a:hover { color: #03A9F4; }

        p { margin-top: 15px; font-size: 14px; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required autocomplete="off">
            <input type="email" name="email" placeholder="Email" required autocomplete="off">
            <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
            <input type="submit" value="Register">
        </form>
        <p class="message"><?= $message ?></p>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>