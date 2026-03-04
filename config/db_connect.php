<?php
$dbconf = require __DIR__ . '/database.php';
$conn = new mysqli($dbconf['host'], $dbconf['username'], $dbconf['password'], $dbconf['database']);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}
return $conn;
