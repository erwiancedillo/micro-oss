<?php
session_start();
// load database settings and create connection (config returns array now)
require_once __DIR__ . '/../config/db_connect.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = mysqli_prepare($conn, "SELECT *, COALESCE(role,'user') AS role FROM users WHERE email=?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if($user && password_verify($password, $user['password'])){
    $_SESSION['user_id'] = $user['id'];
    // store role so we can check permissions later
    $_SESSION['role'] = $user['role'];
    header("Location: ../auth/dashboard.php");
}else{
    echo "Invalid Email or Password";
}