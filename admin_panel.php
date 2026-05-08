<?php
session_start();
include "db.php";

if (!isset($_SESSION["admin"])) {
    header("Location: admin_login.php");
    exit;
}

$sql = "SELECT n.id, u.username, n.filename, n.filepath, n.uploaded_at 
        FROM notes n JOIN users u ON n.user_id=u.id 
        ORDER BY n.uploaded_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #e3f2fd, #bbdefb); 
            padding: 20px; 
        }

        h2 { 
            text-align: center; 
            color: #1565c0; 
            margin-bottom: 30px; 
            font-size: 28px;
        }

        /* Fancy Logout Button with ripple effect */
        a.logout-btn {
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            background: linear-gradient(45deg, #d32f2f, #b71c1c);
            padding: 8px 18px;
            border-radius: 8px;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transition: 0.3s;
            display: inline-block;
        }

        a.logout-btn:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 18px rgba(0,0,0,0.3);
        }

        a.logout-btn:after {
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

        a.logout-btn:active:after {
            transform: translate(-50%, -50%) scale(2);
            opacity: 0;
            transition: 0s;
        }

        table { 
            width: 90%; 
            margin: auto; 
            border-collapse: collapse; 
            background: #ffffff; 
            border-radius: 10px; 
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        th, td { 
            padding: 12px 15px; 
            text-align: center; 
        }

        th { 
            background: #1976d2; 
            color: #fff; 
            text-transform: uppercase; 
            letter-spacing: 0.05em; 
        }

        tr:nth-child(even) { 
            background: #f1f8ff; 
        }

        tr:hover { 
            background: #bbdefb; 
            transition: 0.3s; 
        }

        a.delete { 
            color: #d32f2f; 
            font-weight: bold; 
            text-decoration: none; 
            transition: 0.3s;
        }

        a.delete:hover { 
            text-decoration: underline; 
            color: #b71c1c; 
        }

        a.file-link {
            color: #1976d2;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        a.file-link:hover {
            text-decoration: underline;
            color: #0d47a1;
        }
    </style>
</head>
<body>
    <h2>Admin Panel - Welcome <?= $_SESSION["admin"] ?> | 
        <a href="logout.php" class="logout-btn">Logout</a>
    </h2>
    <table>
        <tr>
            <th>User</th>
            <th>File</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php while ($file = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $file["username"] ?></td>
            <td><a href="<?= $file["filepath"] ?>" target="_blank" class="file-link"><?= $file["filename"] ?></a></td>
            <td><?= $file["uploaded_at"] ?></td>
            <td><a href="delete_note.php?id=<?= $file["id"] ?>" class="delete">Delete</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
