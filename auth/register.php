<?php require_once __DIR__ . '/../config/database.php'; ?> 

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Register</title>
<style>
    body {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .login-card {
        background: #fff;
        border-radius: 16px;
        padding: 2rem;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }
    .login-card h4 {
        color: #333;
        font-weight: 600;
    }
    .form-control {
        border-radius: 8px;
        padding: 0.75rem 1rem;
    }
    .btn-success {
        background-color: #28a745;
        border: none;
        border-radius: 8px;
        padding: 0.75rem;
    }
    .btn-success:hover {
        background-color: #218838;
    }
    a {
        color: #2575fc;
    }
</style>
</head>
<body>

<div class="login-card">
<h4 class="text-center mb-4">Register</h4>

<form action="../api/register.php" method="POST">
<input type="text" name="first_name" class="form-control mb-3" placeholder="First Name" required>
<input type="text" name="last_name" class="form-control mb-3" placeholder="Last Name" required>
<input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
<input type="password" name="password" class="form-control mb-4" placeholder="Password" required>
<button type="submit" class="btn btn-success w-100">Register</button>
</form>

<div class="text-center mt-3">
<a href="login.php">Already have an account? Login</a>
</div>
</div>

</body>
</html>