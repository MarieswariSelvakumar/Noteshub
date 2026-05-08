<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$note_id = intval($_GET["note_id"]);

if (isset($_GET["action"]) && $_GET["action"] == "remove") {
    $sql = "DELETE FROM bookmarks WHERE user_id=$user_id AND note_id=$note_id";
    mysqli_query($conn, $sql);
} else {
    $sql = "INSERT IGNORE INTO bookmarks (user_id, note_id) VALUES ($user_id, $note_id)";
    mysqli_query($conn, $sql);
}

header("Location: bookmarks.php");
exit;
