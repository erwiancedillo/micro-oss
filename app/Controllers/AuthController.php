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
            if ($user['status'] !== 'active') {
                $this->loginForm("Your account is pending approval by the Master Administrator.");
                exit();
            }

            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];
            
            $role = $user['role'] ?? 'user';
            $barangay = null;
            
            if ($role === 'master') {
                $barangay = 'master';
            } elseif ($role === 'admin_lizada') {
                $barangay = 'lizada';
            } elseif ($role === 'admin_dalio') {
                $barangay = 'dalio';
            } elseif (!empty($user['barangay'])) {
                $bLower = strtolower($user['barangay']);
                if (in_array($bLower, ['lizada', 'dalio'])) {
                    $barangay = $bLower;
                }
            }

            if (!$barangay && $role === 'master') {
                $barangay = 'master';
            }

            // Preserve master role explicitly; collapse barangay-specific admin roles into 'admin'
            if ($role === 'master') {
                $_SESSION['role'] = 'master';
            } elseif (in_array($role, ['admin_lizada', 'admin_dalio'])) {
                $_SESSION['role'] = 'admin';
            } else {
                if ($barangay && ($role === '' || $role === '0' || $role === 'admin')) {
                    $_SESSION['role'] = 'admin';
                } else {
                    $_SESSION['role'] = $role;
                }
            }

            if (in_array($_SESSION['role'], ['admin', 'master']) && !$barangay) {
                $this->loginForm("Access denied. Admin account has no associated barangay.");
                exit();
            }

            $_SESSION['admin_barangay'] = $barangay;
            $_SESSION['show_welcome_card'] = true; // Set flag for dashboard welcome message
            header('Location: /micro-oss/index.php?route=dashboard');
            exit();
        }
        $this->loginForm("Invalid credentials or account not activated.");
    }

    public function registerForm($error = null, $success = null)
    {
        $alertModel = new \App\Models\BarangayAlert();
        $barangayList = $alertModel->getBarangayNames();
        
        $title = 'Register';
        ob_start();
        include __DIR__ . '/../Views/auth/register.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function register()
    {
        $fullName = trim($_POST['name'] ?? '');
        $barangay = trim($_POST['barangay'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($fullName) || empty($barangay) || empty($email) || empty($password)) {
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
            'status' => 'inactive', // Set to inactive for Master Administrator approval
            'barangay' => $barangay
        ];

        if ($this->userModel->create($data)) {
            return $this->registerForm(null, "Registration successful! Your account is pending approval by the Master Administrator.");
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
            $barangay = trim($_POST['barangay'] ?? '');
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // Validation
            if (empty($firstName) || empty($lastName) || empty($email) || empty($barangay)) {
                $error = 'First name, last name, email, and barangay are required.';
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
            }
            
            if (empty($error)) {
                // Update user
                $userData = [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'role' => $user['role'],
                    'status' => $user['status'],
                    'barangay' => $barangay
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
        
        $alertModel = new \App\Models\BarangayAlert();
        $barangayList = $alertModel->getBarangayNames();
        
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
