<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// load config and create mysqli connection
$conn = require_once __DIR__ . '/../config/db_connect.php';
if (!$conn) {
    die('Database connection failed');
}

require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get form data safely
$first_name = trim($_POST['first_name'] ?? '');
$last_name  = trim($_POST['last_name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$password_raw = $_POST['password'] ?? '';

if (!$first_name || !$last_name || !$email || !$password_raw) {
    die("All fields are required.");
}

$password = password_hash($password_raw, PASSWORD_DEFAULT);

// Check if email exists
$query = mysqli_prepare($conn, "SELECT id FROM users WHERE email=?");
mysqli_stmt_bind_param($query, "s", $email);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);

if (mysqli_num_rows($result) > 0) {
    die("Email already exists.");
}

// Generate activation token
$token = bin2hex(random_bytes(32));

// Insert user
$role = 'user'; // default role for new registrations
$stmt = mysqli_prepare($conn, 
"INSERT INTO users (first_name, last_name, email, password, token, status, role) 
VALUES (?, ?, ?, ?, ?, 'inactive', ?)");

mysqli_stmt_bind_param($stmt, "ssssss", 
    $first_name, $last_name, $email, $password, $token, $role);

if (!mysqli_stmt_execute($stmt)) {
    die("Registration Failed: " . mysqli_error($conn));
}

// Activation link
$activation_link = 
"http://localhost/micro-oss/auth/activate.php?email=" 
. urlencode($email) . 
"&token=" . urlencode($token);

// Send Email Using PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'erwinacedillo@gmail.com';     // 🔴 CHANGE THIS
    $mail->Password   = 'nydtkzlxfogeabij';       // 🔴 USE GMAIL APP PASSWORD
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('erwinacedillo@gmail.com', 'Micro OSS');
    $mail->addAddress($email, $first_name);

    $mail->isHTML(true);
    $mail->Subject = 'Activate your account';
    $mail->Body    = "
        <p>Hello $first_name,</p>
        <p>Please click the link below to activate your account:</p>
        <a href='$activation_link'>Activate Account</a>
    ";

    $mail->send();

    echo "Registration successful! Activation email sent.";

} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}