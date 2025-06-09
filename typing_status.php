<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$status = $_POST['status']; // typing or idle

// Use a dedicated table if needed, or just a cache file or DB row.
file_put_contents("typing_status.json", json_encode(["user" => $username, "status" => $status]));
?>
