<?php

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require_once __DIR__ . '/../app/Models/Database.php';
require_once __DIR__ . '/../app/Models/User.php';

use App\Models\Database;

try {
    $db = Database::getInstance()->getConnection();

    $username = 'master';
    $password = 'master';
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("SELECT id FROM users WHERE LOWER(username) = ? OR role = 'master'");
    $stmt->execute([$username]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        $stmt = $db->prepare("UPDATE users SET first_name = 'Master', last_name = 'Administrator', username = ?, email = 'master@local.system', password = ?, role = 'master', status = 'active', barangay = 'master' WHERE id = ?");
        $stmt->execute([$username, $hashedPassword, $existing['id']]);
        echo "Master account updated successfully.\n";
    } else {
        $stmt = $db->prepare("INSERT INTO users (first_name, last_name, username, email, password, role, status, barangay, created_at) VALUES ('Master', 'Administrator', ?, 'master@local.system', ?, 'master', 'active', 'master', NOW())");
        $stmt->execute([$username, $hashedPassword]);
        echo "Master account created successfully.\n";
    }

    echo "Role: master\nStatus: active\nUsername column and password hash verified.\n";
} catch (Exception $e) {
    die("Error: " . $e->getMessage() . "\n");
}
