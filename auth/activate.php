<?php
// load config and establish mysqli connection
$conn = require_once __DIR__ . '/../config/db_connect.php';
if (!$conn) {
    die("Database connection failed");
}

if(isset($_GET['email']) && isset($_GET['token'])){
    $email = $_GET['email'];
    $token = $_GET['token'];

    // Verify token
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email=? AND token=? AND status='inactive'");
    mysqli_stmt_bind_param($stmt, "ss", $email, $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){
        // Activate account
        $stmt = mysqli_prepare($conn, "UPDATE users SET status='active', token='' WHERE email=?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        echo "Account activated! You can now <a href='login.php'>login</a>.";
    } else {
        echo "Invalid activation link or account already activated.";
    }
}else{
    echo "Invalid activation request.";
}