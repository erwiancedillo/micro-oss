<?php

namespace App\Controllers;

use App\Models\WasteListing;
use App\Models\Junkshop;

class PlasticWasteController
{
    private $wasteListingModel;
    private $junkshopModel;

    public function __construct()
    {
        $this->wasteListingModel = new WasteListing();
        $this->junkshopModel = new Junkshop();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /micro-oss/index.php?route=login');
            exit;
        }

        $userListings = $this->wasteListingModel->getListingsByUser($_SESSION['user_id']);
        $allListings = $this->wasteListingModel->getAllListings();
        $junkshops = $this->junkshopModel->getAll();

        ob_start();
        include __DIR__ . '/../Views/plastic_waste/index.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function addListing()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $data = [
            'user_id' => $_SESSION['user_id'],
            'type' => $_POST['type'] ?? '',
            'weight' => $_POST['weight'] ?? 0,
            'location' => $_POST['location'] ?? '',
            'latitude' => $_POST['latitude'] ?? null,
            'longitude' => $_POST['longitude'] ?? null,
            'status' => 'pending'
        ];

        $success = $this->wasteListingModel->create($data);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Junk listed successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to list junk.']);
        }
    }

    public function apiGetJunkshops()
    {
        header('Content-Type: application/json');
        $junkshops = $this->junkshopModel->getAll();
        echo json_encode(['success' => true, 'data' => $junkshops]);
    }
}
