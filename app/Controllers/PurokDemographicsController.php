<?php

namespace App\Controllers;

use App\Models\PurokDemographics;

class PurokDemographicsController
{
    private $demographicsModel;

    public function __construct()
    {
        $this->demographicsModel = new PurokDemographics();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $is_logged_in = isset($_SESSION['user_id']);
        $is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

        $title = 'Purok Demographics';

        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;

        $total_rows = $this->demographicsModel->getTotalCount();
        $total_pages = ceil($total_rows / $per_page);

        $demographic_data = $this->demographicsModel->getPaginatedData($offset, $per_page);
        $totals = $this->demographicsModel->getTotals();

        ob_start();
        include __DIR__ . '/../Views/purok-demographics.php';
        $content = ob_get_clean();

        include __DIR__ . '/../Views/layout.php';
    }

    public function apiGetPurokData()
    {
        header('Content-Type: application/json');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $purokName = $_GET['purok_name'] ?? '';
        if (empty($purokName)) {
            echo json_encode(['success' => false, 'message' => 'Purok name is required']);
            return;
        }

        $data = $this->demographicsModel->getPurokByPurokName($purokName);
        if ($data) {
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Purok data not found']);
        }
    }

    public function update()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error_message'] = "Unauthorized: Admin access required.";
            header("Location: /micro-oss/index.php?route=purok-demographics");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $purokName = $_POST['purok_name'] ?? '';

            $data = [
                'total_families' => (int)($_POST['total_families'] ?? 0),
                'total_persons_male' => (int)($_POST['total_persons_male'] ?? 0),
                'total_persons_female' => (int)($_POST['total_persons_female'] ?? 0),
                'infant_male' => (int)($_POST['infant_male'] ?? 0),
                'infant_female' => (int)($_POST['infant_female'] ?? 0),
                'children_male' => (int)($_POST['children_male'] ?? 0),
                'children_female' => (int)($_POST['children_female'] ?? 0),
                'adult_male' => (int)($_POST['adult_male'] ?? 0),
                'adult_female' => (int)($_POST['adult_female'] ?? 0),
                'elderly_male' => (int)($_POST['elderly_male'] ?? 0),
                'elderly_female' => (int)($_POST['elderly_female'] ?? 0),
                'pwd_male' => (int)($_POST['pwd_male'] ?? 0),
                'pwd_female' => (int)($_POST['pwd_female'] ?? 0),
                'sickness_male' => (int)($_POST['sickness_male'] ?? 0),
                'sickness_female' => (int)($_POST['sickness_female'] ?? 0),
                'pregnant_women' => (int)($_POST['pregnant_women'] ?? 0)
            ];

            if ($this->demographicsModel->updatePurokData($purokName, $data)) {
                $_SESSION['success_message'] = "Purok demographic data for $purokName updated successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to update purok demographic data.";
            }
        }

        header("Location: /micro-oss/index.php?route=purok-demographics");
        exit();
    }
}
