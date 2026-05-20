<?php

namespace App\Controllers;

use App\Models\Resource;

class ResourceAssessmentController
{
    private $resourceModel;

    public function __construct()
    {
        $this->resourceModel = new Resource();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            header('Location: /micro-oss/index.php?route=login');
            exit;
        }

        $resources = $this->resourceModel->getAllResources();

        ob_start();
        include __DIR__ . '/../Views/resource_assessment/index.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function addResource()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $data = [
            'barangay' => $_POST['barangay'] ?? '',
            'type' => $_POST['type'] ?? '',
            'quantity' => $_POST['quantity'] ?? 0,
            'status' => $_POST['status'] ?? 'available'
        ];

        $success = $this->resourceModel->create($data);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Resource added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add resource.']);
        }
    }

    public function apiGetResources()
    {
        header('Content-Type: application/json');
        $resources = $this->resourceModel->getAllResources();
        echo json_encode(['success' => true, 'data' => $resources]);
    }

    public function updateResourceStatus()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        header('Content-Type: application/json');

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $id = $_POST['id'] ?? '';
        $status = $_POST['status'] ?? '';
        if ($id && $status) {
            if ($this->resourceModel->updateStatus($id, $status)) {
                echo json_encode(['success' => true]);
                return;
            }
        }
        echo json_encode(['success' => false, 'message' => 'Update failed.']);
    }
}
