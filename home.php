<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        body, html { margin:0; padding:0; height:100%; font-family:'Segoe UI', sans-serif; overflow: hidden; }

        /* Animated Gradient Background */
        body {
            background: linear-gradient(270deg, #E0F7FA, #B2EBF2, #81D4FA, #4FC3F7);
            background-size: 800% 800%;
            animation: gradientBG 15s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            width: 520px;
            padding: 40px 30px;
            border-radius: 20px;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            text-align: center;
            color: #0277BD;
            position: relative;
            overflow: hidden;
        }

        h1 {
            font-size: 34px;
            margin-bottom: 15px;
            color: #0288D1;
        }

        p {
            font-size: 16px;
            color: #444;
            margin-bottom: 30px;
        }

        /* Fancy Buttons (Enhanced) */
        a {
            position: relative;
            display: inline-block;
            margin: 12px;
            padding: 14px 28px;
            border-radius: 14px;
            background: linear-gradient(45deg, #03A9F4, #0288D1);
            color: #fff;
            font-weight: bold;
            text-decoration: none;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s, background 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* Light streak hover effect */
        a::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255,255,255,0.2);
            transform: rotate(45deg) scale(0);
            transition: transform 0.5s, opacity 0.5s;
            pointer-events: none;
        }

        a:hover::before {
            transform: rotate(45deg) scale(1);
            opacity: 0.5;
        }

        a:hover {
            transform: translateY(-5px) scale(1.07);
            box-shadow: 0 10px 30px rgba(0,0,0,0.35);
            background: linear-gradient(45deg, #0288D1, #03A9F4);
        }

        /* Ripple effect on click */
        a:active::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            width: 120%;
            height: 120%;
            background: rgba(255,255,255,0.4);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            animation: rippleEnhanced 0.6s ease-out forwards;
        }

        @keyframes rippleEnhanced {
            to { transform: translate(-50%, -50%) scale(2); opacity: 0; }
        }

        @media(max-width: 600px){
            .container { width: 90%; padding: 30px 20px; }
            a { width: 80%; margin: 10px 0; display: block; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>👋 Welcome <?= $_SESSION["username"]; ?></h1>
        <p>This is your personal dashboard. Choose what you’d like to do:</p>

        <a href="upload.php">📤 Upload Notes & Videos</a>
        <a href="uploads.php">📂 View My Files</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
</body>
</html>
