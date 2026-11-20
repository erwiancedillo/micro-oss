<?php

require_once __DIR__ . '/../app/Models/Database.php';
require_once __DIR__ . '/../app/Models/User.php';

use App\Models\Database;
use App\Models\User;

try {
    $db = Database::getInstance()->getConnection();

    $username = 'master';
    $password = 'master';
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("SELECT id FROM users WHERE email = ? OR role = 'master'");
    $stmt->execute([$username]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        $stmt = $db->prepare("UPDATE users SET first_name = 'Master', last_name = 'Administrator', email = ?, password = ?, role = 'master', status = 'active', barangay = 'master' WHERE id = ?");
        $stmt->execute([$username, $hashedPassword, $existing['id']]);
        echo "Master account updated successfully.\n";
    } else {
        $stmt = $db->prepare("INSERT INTO users (first_name, last_name, email, password, role, status, barangay, created_at) VALUES ('Master', 'Administrator', ?, ?, 'master', 'active', 'master', NOW())");
        $stmt->execute([$username, $hashedPassword]);
        echo "Master account created successfully.\n";
    }

    echo "Username: $username\n";
    echo "Password: $password\n";
    echo "Role: master\n";
    echo "Status: active\n";

} catch (Exception $e) {
    die("Error: " . $e->getMessage() . "\n");
}
