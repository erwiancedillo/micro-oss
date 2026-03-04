<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db_connect.php';

$output = ['created'=>[], 'errors'=>[]];

function hasColumn($conn, $table, $column) {
    $t = mysqli_real_escape_string($conn, $table);
    $c = mysqli_real_escape_string($conn, $column);
    $res = $conn->query("SHOW COLUMNS FROM `{$t}` LIKE '{$c}'");
    return $res && $res->num_rows > 0;
}

if (!hasColumn($conn,'users','role')) {
    if ($conn->query("ALTER TABLE users ADD COLUMN role ENUM('user','admin') NOT NULL DEFAULT 'user'")) {
        $output['created'][] = 'users.role';
    } else {
        $output['errors'][] = $conn->error;
    }
}

echo json_encode($output, JSON_PRETTY_PRINT);
$conn->close();
