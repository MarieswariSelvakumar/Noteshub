<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["username"] !== "admin") {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        /* Reset & font */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }

        body {
            background: linear-gradient(135deg, #90CAF9, #E3F2FD);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            width: 100%;
            background: #1565C0;
            color: white;
            padding: 20px 30px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }

        .welcome {
            margin: 30px 0;
            font-size: 20px;
            color: #0277BD;
        }

        .dashboard {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            width: 250px;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            text-align: center;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.2);
        }

        .card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 18px;
            border-radius: 10px;
            background: #03A9F4;
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }

        .card a:hover { background: #0288D1; }

        footer {
            width: 100%;
            text-align: center;
            padding: 15px;
            background: #1565C0;
            color: white;
            position: fixed;
            bottom: 0;
        }

        @media(max-width: 600px) {
            .dashboard { flex-direction: column; align-items: center; }
        }
    </style>
</head>
<body>

<header>🛠 Admin Dashboard</header>

<div class="welcome">Welcome, <?= $_SESSION["username"]; ?> (Admin)</div>

<div class="dashboard">
    <div class="card">
        <h3>Manage Users</h3>
        <p>View, edit, and delete registered users.</p>
        <a href="manage_users.php">Go</a>
    </div>
    <div class="card">
        <h3>Manage Notes</h3>
        <p>Review, approve, or remove uploaded notes.</p>
        <a href="manage_notes.php">Go</a>
    </div>
    <div class="card">
        <h3>View Stats</h3>
        <p>See total users, uploads, and activity logs.</p>
        <a href="stats.php">Go</a>
    </div>
    <div class="card">
        <h3>Logout</h3>
        <p>End your session securely.</p>
        <a href="logout.php">Logout</a>
    </div>
</div>

<footer>© <?= date("Y") ?> Notes Sharing Platform | Admin Panel</footer>

</body>
</html>
