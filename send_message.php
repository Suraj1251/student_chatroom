<?php
include 'db.php';

$message = $_POST['message'] ?? '';
$username = $_POST['username'] ?? 'Anonymous';
$file_path = null;

if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $filename = basename($_FILES["file"]["name"]);
    $target_path = $upload_dir . time() . "_" . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $filename); // sanitize
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_path)) {
        $file_path = $target_path;
    }
}

$stmt = $conn->prepare("INSERT INTO messages (username, message, file_path) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $message, $file_path);
$stmt->execute();
$stmt->close();
?>
