<?php
session_start();
include "db.php";

if (!isset($_SESSION["admin"])) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM notes WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $note = mysqli_fetch_assoc($result);

    if ($note) {
        if (file_exists($note["filepath"])) {
            unlink($note["filepath"]);
        }
        mysqli_query($conn, "DELETE FROM notes WHERE id='$id'");
    }
}
header("Location: admin_panel.php");
exit;
?>
