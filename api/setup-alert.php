<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db_connect.php';

function hasColumn(mysqli $conn, string $table, string $column): bool
{
    $t = $conn->real_escape_string($table);
    $c = $conn->real_escape_string($column);
    $query = "SHOW COLUMNS FROM `{$t}` LIKE '{$c}'";
    $res = $conn->query($query);
    return $res && $res->num_rows > 0;
}

$created = [];
$errors = [];

// barangay_polygons
if (!hasColumn($conn, 'barangay_polygons', 'alert_level')) {
    if ($conn->query("ALTER TABLE barangay_polygons ADD COLUMN alert_level TINYINT NOT NULL DEFAULT 0")) {
        $created[] = 'barangay_polygons.alert_level';
    } else {
        $errors[] = $conn->error;
    }
}
if (!hasColumn($conn, 'barangay_polygons', 'flood_advisory')) {
    if ($conn->query("ALTER TABLE barangay_polygons ADD COLUMN flood_advisory TEXT")) {
        $created[] = 'barangay_polygons.flood_advisory';
    } else {
        $errors[] = $conn->error;
    }
}

// sitios
if (!hasColumn($conn, 'sitios', 'flood_level')) {
    if ($conn->query("ALTER TABLE sitios ADD COLUMN flood_level TINYINT NOT NULL DEFAULT 0")) {
        $created[] = 'sitios.flood_level';
    } else {
        $errors[] = $conn->error;
    }
}
if (!hasColumn($conn, 'sitios', 'flood_advisory')) {
    if ($conn->query("ALTER TABLE sitios ADD COLUMN flood_advisory TEXT")) {
        $created[] = 'sitios.flood_advisory';
    } else {
        $errors[] = $conn->error;
    }
}

$response = ['created' => $created];
if (!empty($errors)) {
    $response['errors'] = $errors;
}

echo json_encode($response, JSON_PRETTY_PRINT);
$conn->close();
