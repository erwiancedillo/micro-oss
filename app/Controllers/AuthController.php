<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function loginForm($error = null)
    {
        $googleConfig = __DIR__ . '/../../config/google.php';
        $googleURL = '#';
        if (file_exists($googleConfig)) {
            require_once $googleConfig;
            if (isset($client)) {
                $googleURL = $client->createAuthUrl();
            }
        }

        $title = 'Login';
        ob_start();
        include __DIR__ . '/../Views/auth/login.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = $this->userModel->findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'] ?? 'user';
            header('Location: /micro-oss/index.php?route=dashboard');
            exit();
        }
        $this->loginForm("Invalid credentials or account not activated.");
    }

    public function registerForm($error = null, $success = null)
    {
        $title = 'Register';
        ob_start();
        include __DIR__ . '/../Views/auth/register.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function register()
    {
        $fullName = trim($_POST['name']);
        $nameParts = explode(' ', $fullName, 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        $data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => trim($_POST['email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'token' => bin2hex(random_bytes(32)),
            'status' => 'inactive'
        ];
        // TODO: send activation email etc.
        if ($this->userModel->create($data)) {
             $this->registerForm(null, "Registration successful! You can now login.");
        } else {
             $this->registerForm("Registration failed.");
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /micro-oss/index.php?route=login');
        exit();
    }

    public function dashboard()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /micro-oss/index.php?route=login');
            exit();
        }
        $title = 'Dashboard';
        ob_start();
        include __DIR__ . '/../Views/auth/dashboard.php';
        $content = ob_get_clean();
        
        // Use a simpler layout or direct include for Tailwind dashboard if preferred, 
        // but for consistency we use layout.php
        include __DIR__ . '/../Views/layout.php';
    }
}
