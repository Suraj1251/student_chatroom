<?php
include 'db.php';
$result = $conn->query("SELECT * FROM messages ORDER BY timestamp ASC");

while ($row = $result->fetch_assoc()) {
    $user = htmlspecialchars($row['username']);
    $msg = htmlspecialchars($row['message']);
    $filePath = $row['file_path'] ?? null;
    $time = date("g:i A", strtotime($row['timestamp']));
    $alignment = ($user === $_GET['user']) ? 'right' : 'left';

    $content = "";

    // If there's a file, display it
    if ($filePath) {
        $safePath = htmlspecialchars($filePath);
        $ext = pathinfo($safePath, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) {
            $content .= "<img src='$safePath' style='max-width: 100%; border-radius: 8px;'><br>";
        } else {
            $content .= "<a href='$safePath' target='_blank'>📎 Download File</a><br>";
        }
    }

    // If there's text too, show it
    if (!empty($msg)) {
        $content .= htmlspecialchars($msg);
    }

    echo "<div class='msg-bubble $alignment'>
            <div class='msg-text'>$content</div>
            <div class='msg-meta'>$user • $time</div>
          </div>";
}
?>
