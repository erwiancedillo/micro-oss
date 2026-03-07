<?php

// core connection previously used directly, now return for MVC Database class
return [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'micro_oss'
];

// legacy usage (in case some scripts still rely on it)
/*
$host = "localhost";
$username = "root";
$password = "misadmin";
$database = "micro_oss";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
*/