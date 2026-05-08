<?php
session_start();
include "db.php";

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$note_id = intval($_GET['id']);

// Fetch file details
$sql = "SELECT * FROM notes WHERE id='$note_id'";
$result = mysqli_query($conn, $sql);
if ($row = mysqli_fetch_assoc($result)) {
    $filePath = $row['filepath'];

    if (file_exists($filePath)) {
        // Increment downloads count
        mysqli_query($conn, "UPDATE notes SET downloads = downloads + 1 WHERE id='$note_id'");

        // Force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        echo "File not found!";
    }
} else {
    echo "Invalid file ID!";
}
?>
