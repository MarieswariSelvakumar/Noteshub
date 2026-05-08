<?php
include "db.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch file
    $sql = "SELECT * FROM notes WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $file = $row['filepath'];

        if (file_exists($file)) {
            // Increase view count
            mysqli_query($conn, "UPDATE notes SET views = views + 1 WHERE id=$id");

            // Show file (image/pdf/doc/txt etc.)
            $ext = strtolower(pathinfo($row['filename'], PATHINFO_EXTENSION));

            if (in_array($ext, ['jpg','jpeg','png','gif'])) {
                // Show image inline
                header("Content-Type: image/" . $ext);
                readfile($file);
            } elseif ($ext == "pdf") {
                header("Content-Type: application/pdf");
                readfile($file);
            } elseif (in_array($ext, ['txt','doc','docx'])) {
                // Let browser decide (open or download)
                header("Content-Type: application/octet-stream");
                readfile($file);
            } else {
                // Default fallback
                header("Content-Type: application/octet-stream");
                readfile($file);
            }
            exit;
        } else {
            echo "File not found!";
        }
    } else {
        echo "Invalid file ID!";
    }
} else {
    echo "No file selected!";
}
?>
