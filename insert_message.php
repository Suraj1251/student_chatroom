<?php
include 'db.php';
if (!isset($_POST['username']) || !isset($_POST['message'])) exit;

$username = $_POST['username'];
$message = $_POST['message'];

$stmt = $conn->prepare("INSERT INTO messages (username, message) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $message);
$stmt->execute();
?>
