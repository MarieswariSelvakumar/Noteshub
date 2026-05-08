<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT n.id, n.filename, n.filepath, n.uploaded_at, u.username 
        FROM bookmarks b 
        JOIN notes n ON b.note_id = n.id
        JOIN users u ON n.user_id = u.id
        WHERE b.user_id = $user_id
        ORDER BY b.created_at DESC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Bookmarks</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; padding: 20px; }
        table { width: 80%; margin: auto; border-collapse: collapse; background: #fff; }
        th, td { padding: 12px; border: 1px solid #ccc; text-align: center; }
        th { background: #007bff; color: #fff; }
        a { text-decoration: none; color: #007bff; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">💖 My Bookmarked Notes</h2>
    <table>
        <tr>
            <th>Filename</th>
            <th>Uploaded By</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= htmlspecialchars($row['filename']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= $row['uploaded_at'] ?></td>
            <td>
                <a href="view.php?id=<?= $row['id'] ?>">👁 View</a> | 
                <a href="bookmark.php?action=remove&note_id=<?= $row['id'] ?>">❌ Remove</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <div style="text-align:center;margin-top:20px;">
        <a href="index.php">⬅ Back to Home</a>
    </div>
</body>
</html>
