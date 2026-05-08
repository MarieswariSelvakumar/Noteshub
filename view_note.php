<?php
session_start();
include "db.php";

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$note_id = intval($_GET['id']);
$user_id = $_SESSION["user_id"] ?? null;

// Fetch note details
$sql_note = "SELECT * FROM notes WHERE id=$note_id";
$result_note = mysqli_query($conn, $sql_note);
if (!$note = mysqli_fetch_assoc($result_note)) {
    die("Note not found!");
}

// Increase view count (only once per page load)
mysqli_query($conn, "UPDATE notes SET views = views + 1 WHERE id=$note_id");

// Handle review submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($user_id)) {
    $rating = intval($_POST["rating"]);
    $comment = mysqli_real_escape_string($conn, $_POST["comment"]);

    // Optional: prevent multiple reviews by same user
    $check = mysqli_query($conn, "SELECT * FROM reviews WHERE note_id='$note_id' AND user_id='$user_id'");
    if (mysqli_num_rows($check) == 0) {
        $sql = "INSERT INTO reviews (note_id, user_id, rating, comment) 
                VALUES ('$note_id', '$user_id', '$rating', '$comment')";
        mysqli_query($conn, $sql);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Note</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; padding: 20px; }
        .container { background: #fff; padding: 20px; border-radius: 8px; width: 70%; margin: auto; }
        textarea, select, input[type=submit] {
            width: 100%; padding: 10px; margin: 10px 0;
            border-radius: 5px; border: 1px solid #ccc;
        }
        input[type=submit] { background: #28a745; color: white; border: none; cursor: pointer; }
        input[type=submit]:hover { background: #218838; }
        .review { border-bottom: 1px solid #ddd; padding: 10px; }
        .rating { color: gold; }
        img, embed { max-width: 100%; margin: 10px 0; border-radius: 5px; }
        .file-preview { margin-bottom: 20px; }
        a { text-decoration: none; color: #007bff; }
        a:hover { text-decoration: underline; }
        small { color: #555; display: block; margin-top: 5px; }
    </style>
</head>
<body>
<div class="container">
    <h2><?= htmlspecialchars($note['filename']) ?></h2>

    <div class="file-preview">
        <?php
        $ext = strtolower(pathinfo($note['filename'], PATHINFO_EXTENSION));
        $file = $note['filepath'];

        if (in_array($ext, ['jpg','jpeg','png','gif'])) {
            echo "<img src='" . htmlspecialchars($file) . "' alt='Note Image'>";
        } elseif ($ext == 'pdf') {
            echo "<embed src='" . htmlspecialchars($file) . "' width='100%' height='600px' type='application/pdf'>";
        } elseif (in_array($ext, ['txt','doc','docx'])) {
            echo "<p>Cannot preview this file. <a href='download.php?id=$note_id'>Download</a></p>";
        } else {
            echo "<p>Cannot preview this file. <a href='download.php?id=$note_id'>Download</a></p>";
        }

        echo "<small>👁 Viewed: " . $note['views'] . " times | ⬇ Downloaded: " . $note['downloads'] . " times</small>";
        ?>
    </div>

    <?php if ($user_id) { ?>
    <form method="post">
        <label>Rate this note:</label>
        <select name="rating" required>
            <option value="">--Select--</option>
            <option value="1">⭐</option>
            <option value="2">⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="5">⭐⭐⭐⭐⭐</option>
        </select>
        <textarea name="comment" placeholder="Leave a comment..." required></textarea>
        <input type="submit" value="Submit Review">
    </form>
    <?php } else { ?>
        <p><a href="login.php">Login</a> to rate and comment.</p>
    <?php } ?>

    <h3>All Reviews:</h3>
    <?php
    $reviews = mysqli_query($conn, "SELECT r.*, u.username 
                                   FROM reviews r 
                                   JOIN users u ON r.user_id=u.id 
                                   WHERE r.note_id='$note_id' 
                                   ORDER BY r.created_at DESC");
    if (mysqli_num_rows($reviews) > 0) {
        while ($rev = mysqli_fetch_assoc($reviews)) {
            echo "<div class='review'>";
            echo "<strong>" . htmlspecialchars($rev['username']) . "</strong> ";
            echo "<span class='rating'>" . str_repeat("⭐", $rev['rating']) . "</span>";
            echo "<p>" . htmlspecialchars($rev['comment']) . "</p>";
            echo "<small>" . $rev['created_at'] . "</small>";
            echo "</div>";
        }
    } else {
        echo "<p>No reviews yet.</p>";
    }
    ?>
    <p><a href="uploads.php">⬅ Back to All Notes</a></p>
</div>
</body>
</html>
