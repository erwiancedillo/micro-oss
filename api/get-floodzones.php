<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db_connect.php';

$result = $conn->query("SELECT * FROM flood_zones");
$data = [];

while ($row = $result->fetch_assoc()) {
    $row['polygon'] = json_decode($row['polygon']);
    $data[] = $row;
}

echo json_encode($data, JSON_PRETTY_PRINT);
$conn->close();
?>