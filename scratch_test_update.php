<?php
require_once __DIR__ . '/app/Models/Database.php';
require_once __DIR__ . '/app/Models/User.php';

session_start();
$_SESSION['admin_barangay'] = 'master';

$db = App\Models\Database::getInstance()->getConnection();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$userModel = new App\Models\User();

$id = 1; // Assuming 1 exists, let's list users first
$users = $userModel->getAllUsers();
print_r($users[0]);

$userToUpdate = $users[0]['id'];

$data = [
    'first_name' => 'Test',
    'last_name' => 'Update',
    'email' => 'testupdate@example.com',
    'role' => 'user',
    'status' => 'active',
    'barangay' => 'Lizada'
];

try {
    $res = $userModel->updateUser($userToUpdate, $data);
    echo "Update result: " . ($res ? "true" : "false") . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

$updated = $userModel->getUserById($userToUpdate);
print_r($updated);
