<?php

require_once __DIR__ . '/../app/Models/Database.php';

use App\Models\Database;

try {
    $db = Database::getInstance()->getConnection();
    echo "Connected to database successfully.\n";

    $email = '';
    $password = '';
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if master exists in users
    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        $stmt = $db->prepare("UPDATE users SET role = 'master', barangay = 'master', status = 'active', password = ? WHERE email = ?");
        $stmt->execute([$hashedPassword, $email]);
        echo "Updated existing master account: $email with password: $password\n";
    } else {
        $stmt = $db->prepare("INSERT INTO users (first_name, last_name, email, password, role, status, barangay, created_at) VALUES ('Master', 'Account', ?, ?, 'master', 'active', 'master', NOW())");
        $stmt->execute([$email, $hashedPassword]);
        echo "Created new master account: $email with password: $password\n";
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage() . "\n");
}
