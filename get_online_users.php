<?php
include 'db.php';

// Get users active in last 5 minutes
$result = $conn->query("SELECT DISTINCT username FROM messages WHERE timestamp >= NOW() - INTERVAL 5 MINUTE");

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = htmlspecialchars($row['username']);
}

echo json_encode($users);
?>
