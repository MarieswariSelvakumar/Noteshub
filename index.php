<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>📚 Notes Sharing Platform</title>
    <style>
        /* Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: url("images/bg.jpg") no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        /* Background Overlay */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255,255,255,0.85); 
            z-index: -1;
        }

        /* Header */
        header {
            background: rgba(0, 123, 255, 0.9);
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            border-radius: 0 0 8px 8px;
        }
        header h1 { font-size: 22px; margin-bottom: 10px; }

        /* Search Bar */
        .search-bar {
            display: flex;
            margin: 10px;
        }
        .search-bar input {
            padding: 6px 10px;
            border: none;
            border-radius: 4px 0 0 4px;
            outline: none;
            width: 180px;
        }
        .search-bar button {
            background: #ffcc00;
            border: none;
            padding: 6px 12px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            font-weight: bold;
        }
        .search-bar button:hover { background: #e6b800; }

        /* Nav Links */
        nav { display: flex; flex-wrap: wrap; align-items: center; }
        nav a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }
        nav a:hover { text-decoration: underline; }

        /* Buttons */
        .btn {
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 14px;
            position: relative;
            overflow: hidden;
            z-index: 0;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        /* Ripple effect */
        .btn::after {
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
        .btn:active::after {
            transform: translate(-50%, -50%) scale(2.5);
            opacity: 0;
            transition: 0s;
        }

        .btn.login { background: #28a745; color: white; }
        .btn.register { background: #ffc107; color: black; }
        .btn.logout { background: #dc3545; color: white; }
        .btn.admin { background: #6f42c1; color: white; }

        /* Hero */
        .hero {
            text-align: center;
            padding: 70px 20px;
            background: rgba(0, 123, 255, 0.7);
            color: white;
            margin: 40px auto;
            border-radius: 12px;
            max-width: 900px;
        }
        .hero h2 { font-size: 32px; margin-bottom: 15px; }
        .hero p { font-size: 16px; }

        /* Features */
        .features {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            padding: 50px 20px;
        }
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 240px;
            text-align: center;
            transition: 0.3s;
        }
        .card h3 { margin-bottom: 10px; color: #007bff; }
        .card p { color: #555; font-size: 14px; }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* Footer */
        footer {
            background: rgba(34,34,34,0.9);
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
            font-size: 14px;
            border-radius: 8px 8px 0 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            header { flex-direction: column; }
            nav { margin-top: 10px; }
            nav a { margin: 8px; display: inline-block; }
            .search-bar { width: 100%; justify-content: center; }
            .search-bar input { width: 60%; }
        }
    </style>
</head>
<body>

<header>
    <h1>📚 Notes Sharing</h1>

    <form action="uploads.php" method="get" class="search-bar">
        <input type="text" name="q" placeholder="🔍 Search notes..." required>
        <button type="submit">Search</button>
    </form>

    <nav>
        <a href="index.php">Home</a>
        <a href="uploads.php">All Notes</a>
        <a href="upload.php">Upload</a>
        <a href="bookmarks.php">Bookmarks</a>
        <?php if(isset($_SESSION["user_id"])): ?>
            <a href="logout.php" class="btn logout">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn login">Login</a>
            <a href="register.php" class="btn register">Register</a>
        <?php endif; ?>
        <a href="admin_login.php" class="btn admin">Admin</a>
    </nav>
</header>

<div class="hero">
    <h2>Welcome to the Notes Sharing Platform</h2>
    <p>Upload, Share, Bookmark, and Review Notes – Learn and Grow Together!</p>
</div>

<div class="features">
    <div class="card">
        <h3>⬆ Upload Notes</h3>
        <p>Share your study materials with others by uploading documents and images.</p>
    </div>
    <div class="card">
        <h3>👁 View & Download</h3>
        <p>Access notes from other users, preview them online or download instantly.</p>
    </div>
    <div class="card">
        <h3>⭐ Ratings & Reviews</h3>
        <p>Rate notes and leave reviews to help others choose the best resources.</p>
    </div>
    <div class="card">
        <h3>💖 Bookmarks</h3>
        <p>Save your favorite notes for quick access later.</p>
    </div>
    <div class="card">
        <h3>🛠 Admin Panel</h3>
        <p>Admins can manage users, notes, and reviews from the admin dashboard.</p>
    </div>
</div>

<footer>
    <p>© <?= date("Y") ?> Notes Sharing Platform | Built with ❤️ for Students</p>
</footer>

</body>
</html>
