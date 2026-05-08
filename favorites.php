<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    die("Login to view favorites.");
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT n.*, u.username 
        FROM notes n 
        JOIN users u ON n.user_id=u.id
        JOIN bookmarks b ON b.note_id=n.id
        WHERE b.user_id='$user_id'
        ORDER BY b.created_at DESC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Favorite Notes</title>
</head>
<body>
<h2>💖 My Favorite Notes</h2>
<ul>
<?php while($row = mysqli_fetch_assoc($result)): ?>
    <li>
        <a href="view.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['filename']) ?></a>
        by <?= htmlspecialchars($row['username']) ?>
    </li>
<?php endwhile; ?>
</ul>
<a href="uploads.php">⬅ Back to All Notes</a>
</body>
</html>
