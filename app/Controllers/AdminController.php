<?php

namespace App\Controllers;

use App\Models\BarangayAlert;
use App\Models\EvacuationCenter;
use App\Models\FloodZone;
use App\Models\HazardMap;
use App\Models\IKSModel;
use App\Models\BarangayPolygon;
use App\Models\User;

class AdminController
{
    protected $alertModel;
    protected $centerModel;
    protected $hazardModel;
    protected $iksModel;
    protected $floodZoneModel;
    protected $barangayModel;
    protected $userModel;

    public function __construct()
    {
        $this->alertModel = new BarangayAlert();
        $this->centerModel = new EvacuationCenter();
        $this->hazardModel = new HazardMap();
        $this->iksModel = new IKSModel();
        $this->floodZoneModel = new FloodZone();
        $this->barangayModel = new BarangayPolygon();
        $this->userModel = new User();
    }

    private function checkAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: /micro-oss/index.php?route=login');
            exit();
        }
    }

    public function iks()
    {
        $this->checkAdmin();
        $title = 'Manage Indigenous Knowledge';
        $userName = $_SESSION['user_name'] ?? 'Admin';
        $items = $this->iksModel->getAllItems();
        
        ob_start();
        include __DIR__ . '/../Views/admin/iks.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function createIks()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $icon_url = '';
            
            if (isset($_FILES['icon_image']) && $_FILES['icon_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../assets/uploads/iks/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = time() . '_' . basename($_FILES['icon_image']['name']);
                $targetFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['icon_image']['tmp_name'], $targetFile)) {
                    $icon_url = '/micro-oss/assets/uploads/iks/' . $fileName;
                }
            }
            
            $data['icon_url'] = $icon_url;
            $this->iksModel->createItem($data);
            $_SESSION['flash_message'] = 'IKS item created successfully.';
            header('Location: /micro-oss/index.php?route=admin-iks');
            exit();
        }
    }

    public function editIks()
    {
        $this->checkAdmin();
        $id = $_POST['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $data = $_POST;
            $icon_url = $_POST['existing_icon'] ?? '';
            
            if (isset($_FILES['icon_image']) && $_FILES['icon_image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../assets/uploads/iks/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = time() . '_' . basename($_FILES['icon_image']['name']);
                $targetFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['icon_image']['tmp_name'], $targetFile)) {
                    $icon_url = '/micro-oss/assets/uploads/iks/' . $fileName;
                }
            }
            
            $data['icon_url'] = $icon_url;
            $this->iksModel->updateItem($id, $data);
            $_SESSION['flash_message'] = 'IKS item updated successfully.';
            header('Location: /micro-oss/index.php?route=admin-iks');
            exit();
        }
    }

    public function deleteIks()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->iksModel->deleteItem($id);
            $_SESSION['flash_message'] = 'IKS item deleted successfully.';
        }
        header('Location: /micro-oss/index.php?route=admin-iks');
        exit();
    }

    public function floodZones()
    {
        $this->checkAdmin();
        $title = 'Manage Flood Zones';
        $userName = $_SESSION['user_name'] ?? 'Admin';
        $zones = $this->floodZoneModel->getAllZones();
        
        ob_start();
        include __DIR__ . '/../Views/admin/flood_zones.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function createFloodZone()
    {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'zone_name' => $_POST['zone_name'],
                'risk_level' => $_POST['risk_level'],
                'polygon' => $_POST['polygon']
            ];
            $this->floodZoneModel->createZone($data);
            $_SESSION['flash_message'] = 'Flood zone created successfully.';
            header('Location: /micro-oss/index.php?route=admin-flood-zones');
            exit();
        }
    }

    public function editFloodZone()
    {
        $this->checkAdmin();
        $id = $_POST['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $data = [
                'zone_name' => $_POST['zone_name'],
                'risk_level' => $_POST['risk_level'],
                'polygon' => $_POST['polygon']
            ];
            $this->floodZoneModel->updateZone($id, $data);
            $_SESSION['flash_message'] = 'Flood zone updated successfully.';
            header('Location: /micro-oss/index.php?route=admin-flood-zones');
            exit();
        }
    }

    public function deleteFloodZone()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->floodZoneModel->deleteZone($id);
            $_SESSION['flash_message'] = 'Flood zone deleted successfully.';
        }
        header('Location: /micro-oss/index.php?route=admin-flood-zones');
        exit();
    }

    public function alerts()
    {
        $this->checkAdmin();
        $title = 'Manage Alerts';
        $userName = $_SESSION['user_name'] ?? 'Admin';
        
        ob_start();
        include __DIR__ . '/../Views/admin/alerts.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function dashboard()
    {
        $this->checkAdmin();
        $title = 'Admin Dashboard';
        $userName = $_SESSION['user_name'] ?? 'Admin';
        $stats = $this->centerModel->getStats();
        $barangayPolygons = $this->barangayModel->getAllPolygons();
        $floodZones = $this->floodZoneModel->getAllZones();
        
        ob_start();
        include __DIR__ . '/../Views/admin/dashboard.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function hazardMaps()
    {
        $this->checkAdmin();
        $title = 'Manage Hazard Maps';
        $userName = $_SESSION['user_name'] ?? 'Admin';
        $maps = $this->hazardModel->getAllHazardMaps();
        
        ob_start();
        include __DIR__ . '/../Views/admin/hazard_maps.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function createHazardMap()
    {
        $this->checkAdmin();
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            
            $image_url = '';
            if (isset($_FILES['image'])) {
                if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../assets/uploads/hazard_maps/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $fileName = time() . '_' . basename($_FILES['image']['name']);
                    $targetFile = $uploadDir . $fileName;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                        $image_url = '/micro-oss/assets/uploads/hazard_maps/' . $fileName;
                    } else {
                        $error = 'Failed to move uploaded file. Check directory permissions.';
                    }
                } else {
                    $error = 'Upload error: ' . $this->getUploadError($_FILES['image']['error']);
                }
            }

            if (!$error) {
                $id = $this->hazardModel->createHazardMap([
                    'name' => $name,
                    'description' => $description,
                    'image_url' => $image_url ?: 'toril.png'
                ]);

                $_SESSION['flash_message'] = 'Hazard map created successfully.';
                header('Location: /micro-oss/index.php?route=admin-hazard-maps');
                exit();
            }
        }

        $title = 'Add Hazard Map';
        $userName = $_SESSION['user_name'] ?? 'Admin';
        
        ob_start();
        include __DIR__ . '/../Views/admin/hazard_map_form.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function editHazardMap()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /micro-oss/index.php?route=admin-hazard-maps');
            exit();
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $existing_image = $_POST['existing_image'];
            
            $image_url = $existing_image;
            if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
                if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../assets/uploads/hazard_maps/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $fileName = time() . '_' . basename($_FILES['image']['name']);
                    $targetFile = $uploadDir . $fileName;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                        $image_url = '/micro-oss/assets/uploads/hazard_maps/' . $fileName;
                    } else {
                        $error = 'Failed to move uploaded file.';
                    }
                } else {
                    $error = 'Upload error: ' . $this->getUploadError($_FILES['image']['error']);
                }
            }

            if (!$error) {
                $this->hazardModel->updateHazardMap($id, [
                    'name' => $name,
                    'description' => $description,
                    'image_url' => $image_url
                ]);

                $_SESSION['flash_message'] = 'Hazard map updated successfully.';
                header('Location: /micro-oss/index.php?route=admin-hazard-maps');
                exit();
            }
        }

        $map = $this->hazardModel->getHazardMapById($id);
        $focusPoints = $this->hazardModel->getFocusPoints($id);
        $title = 'Edit Hazard Map';
        $userName = $_SESSION['user_name'] ?? 'Admin';
        
        ob_start();
        include __DIR__ . '/../Views/admin/hazard_map_form.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function deleteHazardMap()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->hazardModel->deleteHazardMap($id);
            $_SESSION['flash_message'] = 'Hazard map deleted successfully.';
        }
        header('Location: /micro-oss/index.php?route=admin-hazard-maps');
        exit();
    }

    private function getUploadError($errorCode)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'The uploaded file exceeds the upload_max_filesize directive in php.ini (' . ini_get('upload_max_filesize') . ').';
            case UPLOAD_ERR_FORM_SIZE:
                return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
            case UPLOAD_ERR_PARTIAL:
                return 'The uploaded file was only partially uploaded.';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing a temporary folder.';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk.';
            case UPLOAD_ERR_EXTENSION:
                return 'A PHP extension stopped the file upload.';
            default:
                return 'Unknown upload error.';
        }
    }

    public function users()
    {
        $this->checkAdmin();
        $title = 'Manage Users';
        $userName = $_SESSION['user_name'] ?? 'Admin';
        $users = $this->userModel->getAllUsers();
        $userStats = $this->userModel->getUserStats();
        
        ob_start();
        include __DIR__ . '/../Views/admin/users.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function createUser()
    {
        $this->checkAdmin();
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($_POST['first_name']);
            $lastName = trim($_POST['last_name']);
            $email = trim($_POST['email']);
            $role = $_POST['role'];
            $status = $_POST['status'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            
            // Validation
            if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
                $error = 'All fields are required.';
            } elseif ($password !== $confirmPassword) {
                $error = 'Passwords do not match.';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters long.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } elseif ($this->userModel->emailExists($email)) {
                $error = 'Email address already exists.';
            } else {
                // Create user
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $token = bin2hex(random_bytes(32));
                
                $userData = [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'token' => $token,
                    'status' => $status
                ];
                
                if ($this->userModel->create($userData)) {
                    $_SESSION['flash_message'] = 'User created successfully.';
                    header('Location: /micro-oss/index.php?route=admin-users');
                    exit();
                } else {
                    $error = 'Failed to create user. Please try again.';
                }
            }
        }
        
        $title = 'Add User';
        $userName = $_SESSION['user_name'] ?? 'Admin';
        
        ob_start();
        include __DIR__ . '/../Views/admin/user_form.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function editUser()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? null;
        $error = '';
        
        if (!$id) {
            header('Location: /micro-oss/index.php?route=admin-users');
            exit();
        }
        
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            $_SESSION['flash_message'] = 'User not found.';
            header('Location: /micro-oss/index.php?route=admin-users');
            exit();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($_POST['first_name']);
            $lastName = trim($_POST['last_name']);
            $email = trim($_POST['email']);
            $role = $_POST['role'];
            $status = $_POST['status'];
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            // Validation
            if (empty($firstName) || empty($lastName) || empty($email)) {
                $error = 'First name, last name, and email are required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Please enter a valid email address.';
            } elseif ($this->userModel->emailExists($email, $id)) {
                $error = 'Email address already exists.';
            } elseif (!empty($password) && $password !== $confirmPassword) {
                $error = 'Passwords do not match.';
            } elseif (!empty($password) && strlen($password) < 6) {
                $error = 'Password must be at least 6 characters long.';
            } else {
                // Update user
                $userData = [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'role' => $role,
                    'status' => $status
                ];
                
                if ($this->userModel->updateUser($id, $userData)) {
                    // Update password if provided
                    if (!empty($password)) {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $this->userModel->updateUserPassword($id, $hashedPassword);
                    }
                    
                    $_SESSION['flash_message'] = 'User updated successfully.';
                    header('Location: /micro-oss/index.php?route=admin-users');
                    exit();
                } else {
                    $error = 'Failed to update user. Please try again.';
                }
            }
        }
        
        $title = 'Edit User';
        $userName = $_SESSION['user_name'] ?? 'Admin';
        
        ob_start();
        include __DIR__ . '/../Views/admin/user_form.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function deleteUser()
    {
        $this->checkAdmin();
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header('Location: /micro-oss/index.php?route=admin-users');
            exit();
        }
        
        // Prevent self-deletion
        if ($id == $_SESSION['user_id']) {
            $_SESSION['flash_message'] = 'You cannot delete your own account.';
            header('Location: /micro-oss/index.php?route=admin-users');
            exit();
        }
        
        $user = $this->userModel->getUserById($id);
        if (!$user) {
            $_SESSION['flash_message'] = 'User not found.';
            header('Location: /micro-oss/index.php?route=admin-users');
            exit();
        }
        
        if ($this->userModel->deleteUser($id)) {
            $_SESSION['flash_message'] = 'User deleted successfully.';
        } else {
            $_SESSION['flash_message'] = 'Failed to delete user. Please try again.';
        }
        
        header('Location: /micro-oss/index.php?route=admin-users');
        exit();
    }
}
