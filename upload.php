<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$message = "";

// Allowed file types: documents, images, videos
$allowedTypes = ['txt','doc','docx','pdf','jpg','jpeg','png','mp4','mov','avi','mkv'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $filename = $_FILES["file"]["name"];
    $fileTmp  = $_FILES["file"]["tmp_name"];
    $fileExt  = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if (!in_array($fileExt, $allowedTypes)) {
        $message = "Only TXT, DOC, DOCX, PDF, JPG, JPEG, PNG, MP4, MOV, AVI, MKV files are allowed!";
    } else {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $target = $uploadDir . basename($filename);

        if (move_uploaded_file($fileTmp, $target)) {
            $user_id = $_SESSION["user_id"];
            $sql = "INSERT INTO notes (user_id, filename, filepath) VALUES ('$user_id', '$filename', '$target')";
            if (mysqli_query($conn, $sql)) {
                $message = "File uploaded successfully!";
            } else {
                $message = "Database error: " . mysqli_error($conn);
            }
        } else {
            $message = "Upload failed!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Notes & Videos</title>
    <style>
        body, html { margin:0; padding:0; height:100%; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        body {
            background: linear-gradient(135deg, #E1F5FE, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #01579B;
        }

        .container {
            width: 480px;
            padding: 40px 30px;
            border-radius: 20px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #0288D1;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
        }

        h3 { 
            font-size: 20px;
            margin-bottom: 15px;
            color: #555;
        }

        input[type=file] {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border-radius: 12px;
            border: 1px solid #81D4FA;
            background: rgba(255,255,255,0.9);
            color: #01579B;
            cursor: pointer;
        }

        input[type=submit] {
            width: 100%;
            padding: 15px;
            margin-top: 20px;
            border: none;
            border-radius: 12px;
            background: #03A9F4;
            color: #fff;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            position: relative;
            overflow: hidden;
        }

        input[type=submit]:after {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.6s, opacity 1s;
        }
        input[type=submit]:active:after {
            transform: translate(-50%, -50%) scale(2);
            opacity: 0;
            transition: 0s;
        }
        input[type=submit]:hover { background: #0288D1; }

        /* Logout link styling with fancy animation + ripple */
        .logout-btn {
            display: inline-block;
            padding: 10px 18px;
            font-size: 18px;
            font-weight: bold;
            color: #D32F2F;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
        }
        .logout-btn:hover {
            background: rgba(211,47,47,0.1);
        }
        .logout-btn:after {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            width: 100%;
            height: 100%;
            background: rgba(211,47,47,0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.6s, opacity 1s;
        }
        .logout-btn:active:after {
            transform: translate(-50%, -50%) scale(2);
            opacity: 0;
            transition: 0s;
        }

        a {
            color: #0288D1;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }
        a:hover { color: #03A9F4; }

        .message {
            color: #D32F2F;
            margin-top: 15px;
            font-weight: bold;
        }

        p { margin-top: 12px; font-size: 14px; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome, <?= $_SESSION["username"] ?></h2>
        <p><a href="logout.php" class="logout-btn">Logout</a></p>
        <form method="post" enctype="multipart/form-data">
            <h3>Upload Notes & Videos</h3>
            <input type="file" name="file" accept=".txt,.doc,.docx,.pdf,.jpg,.jpeg,.png,.mp4,.mov,.avi,.mkv" required>
            <input type="submit" value="Upload">
        </form>
        <p class="message"><?= $message ?></p>
        <p><a href="uploads.php">View Uploaded Files</a></p>
    </div>
</body>
</html>
