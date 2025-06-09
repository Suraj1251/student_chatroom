<?php
include 'db.php';
$result = $conn->query("SELECT COUNT(DISTINCT username) AS total FROM messages WHERE timestamp >= NOW() - INTERVAL 5 MINUTE");
$row = $result->fetch_assoc();
echo $row['total'];
?>
