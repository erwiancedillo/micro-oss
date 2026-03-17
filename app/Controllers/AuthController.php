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
            $_SESSION['show_welcome_card'] = true; // Set flag for dashboard welcome message
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
        $fullName = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($fullName) || empty($email) || empty($password)) {
            return $this->registerForm("All fields are required.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->registerForm("Invalid email format.");
        }

        if ($this->userModel->findByEmail($email)) {
            return $this->registerForm("Email already registered.");
        }

        if (strlen($password) < 6) {
            return $this->registerForm("Password must be at least 6 characters long.");
        }

        $nameParts = explode(' ', $fullName, 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        $data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'token' => '',
            'status' => 'active' // Set to active for immediate login
        ];

        if ($this->userModel->create($data)) {
            return $this->registerForm(null, "Registration successful! You can now login.");
        } else {
            return $this->registerForm("Registration failed. Please try again.");
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

    public function userProfile()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /micro-oss/index.php?route=login');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($userId);
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($_POST['first_name']);
            $lastName = trim($_POST['last_name']);
            $email = trim($_POST['email']);
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // Validation
            if (empty($firstName) || empty($lastName) || empty($email)) {
                $error = 'First name, last name, and email are required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } elseif ($this->userModel->emailExists($email, $userId)) {
                $error = 'Email address already exists.';
            } elseif (!empty($newPassword)) {
                if (empty($currentPassword)) {
                    $error = 'Current password is required to change password.';
                } elseif (!$this->verifyCurrentPassword($userId, $currentPassword)) {
                    $error = 'Current password is incorrect.';
                } elseif ($newPassword !== $confirmPassword) {
                    $error = 'New passwords do not match.';
                } elseif (strlen($newPassword) < 6) {
                    $error = 'New password must be at least 6 characters long.';
                }
            } else {
                // Update user
                $userData = [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'role' => $user['role'],
                    'status' => $user['status']
                ];
                
                if ($this->userModel->updateUser($userId, $userData)) {
                    // Update password if provided
                    if (!empty($newPassword)) {
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        $this->userModel->updateUserPassword($userId, $hashedPassword);
                    }
                    
                    $_SESSION['flash_message'] = 'Profile updated successfully.';
                    header('Location: /micro-oss/index.php?route=user-profile');
                    exit();
                } else {
                    $error = 'Failed to update profile. Please try again.';
                }
            }
        }
        
        $title = 'My Profile';
        ob_start();
        include __DIR__ . '/../Views/auth/user_profile.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    private function verifyCurrentPassword($userId, $currentPassword)
    {
        // Get user with password from database
        $db = \App\Models\Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT password FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        $userWithPassword = $stmt->fetch();
        
        if (!$userWithPassword) {
            return false;
        }
        
        return password_verify($currentPassword, $userWithPassword['password']);
    }
}
