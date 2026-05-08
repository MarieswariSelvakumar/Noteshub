<?php
session_start();
include "db.php";

// Fetch all uploaded notes with user info + views/downloads
$sql = "SELECT n.id, u.username, n.filename, n.filepath, n.uploaded_at, n.downloads, n.views 
        FROM notes n 
        JOIN users u ON n.user_id = u.id 
        ORDER BY n.uploaded_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Uploaded Notes</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; padding: 20px; }
        table { width: 90%; margin: auto; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; vertical-align: middle; }
        th { background: #007bff; color: #fff; }
        a { text-decoration: none; color: #007bff; font-weight: bold; }
        a:hover { text-decoration: underline; }
        img { border-radius: 5px; max-width: 120px; margin-bottom: 5px; }
        h2 { text-align: center; margin-bottom: 20px; }
        .back-link { text-align: center; margin-top: 20px; }
        small { color: #555; display: block; margin-top: 5px; }
    </style>
</head>
<body>
    <h2>📂 Uploaded Notes</h2>
    <table>
        <tr>
            <th>User</th>
            <th>Preview / File</th>
            <th>Date</th>
            <th>Actions & Ratings</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { 
            $noteId = $row['id'];

            // Average rating and total reviews
            $avgRes = mysqli_query($conn, "SELECT AVG(rating) AS avg_rating, COUNT(*) AS total FROM reviews WHERE note_id='$noteId'");
            $avgData = mysqli_fetch_assoc($avgRes);
            $totalReviews = $avgData['total'] ?? 0;
            if ($totalReviews > 0 && $avgData['avg_rating'] !== null) {
                $avgRating = round($avgData['avg_rating'], 1);
                $stars = str_repeat("⭐", round($avgRating));
                $ratingDisplay = "$stars $avgRating/5 ($totalReviews reviews)";
            } else {
                $ratingDisplay = "No reviews yet";
            }

            // Bookmark status
            $isBookmarked = false;
            if (isset($_SESSION['user_id'])) {
                $check = mysqli_query($conn, "SELECT * FROM bookmarks WHERE user_id={$_SESSION['user_id']} AND note_id=$noteId");
                if (mysqli_num_rows($check) > 0) $isBookmarked = true;
            }
        ?>
        <tr>
            <td><?= htmlspecialchars($row["username"]) ?></td>
            <td>
                <?php 
                $ext = strtolower(pathinfo($row['filename'], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg','jpeg','png','gif'])) {
                    echo "<img src='" . htmlspecialchars($row['filepath']) . "'><br>";
                }
                echo htmlspecialchars($row['filename']);
                ?>
            </td>
            <td><?= $row["uploaded_at"] ?></td>
            <td>
                <a href="view_note.php?id=<?= $row['id'] ?>" target="_blank">👁 View</a> | 
                <a href="download.php?id=<?= $row['id'] ?>">⬇ Download</a>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <br>
                    <a href="bookmark.php?note_id=<?= $noteId ?>">
                        <?= $isBookmarked ? '💖 Unbookmark' : '🤍 Bookmark' ?>
                    </a>
                <?php endif; ?>
                <small>👁 Viewed <?= $row['views'] ?> times</small>
                <small>⬇ Downloaded <?= $row['downloads'] ?> times</small>
                <small><?= $ratingDisplay ?></small>
            </td>
        </tr>
        <?php } ?>
    </table>
    <div class="back-link">
        <a href="upload.php">⬅ Back to Upload</a>
    </div>
</body>
</html>
