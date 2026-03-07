<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
// establish database connection using the central handler
$conn = require_once __DIR__ . '/../config/db_connect.php';
if (!$conn) {
    die("Database connection failed");
}
require_once __DIR__ . '/../config/google.php';

if (!isset($_GET['code'])) {
    die("Invalid Google Response");
}

$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

if (isset($token['error'])) {
    die("Google Authentication Failed: " . $token['error']);
}

$client->setAccessToken($token['access_token']);

$google = new Google_Service_Oauth2($client);
$data = $google->userinfo->get();

$google_id  = $data->id;
$email      = $data->email;
$first_name = $data->givenName ?? '';
$last_name  = $data->familyName ?? '';

// Check if user exists
$stmt = mysqli_prepare($conn, "SELECT id, COALESCE(role,'user') AS role FROM users WHERE google_id=? OR email=?");
mysqli_stmt_bind_param($stmt, "ss", $google_id, $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    $stmt = mysqli_prepare($conn, "INSERT INTO users (first_name, last_name, email, google_id) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $first_name, $last_name, $email, $google_id);
    mysqli_stmt_execute($stmt);
    $user_id = mysqli_insert_id($conn);
    $role = 'user';
} else {
    $user_id = $user['id'];
    $role = $user['role'];
}

$_SESSION['user_id'] = $user_id;
$_SESSION['role'] = $role;

header("Location: ../auth/dashboard.php");
exit();
