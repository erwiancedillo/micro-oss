<?php

namespace App\Controllers;

use App\Models\BarangayPolygon;

class EvacuationController
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /micro-oss/index.php?route=login');
            exit();
        }
        $userName = $_SESSION['user_name'] ?? 'Guest';
        $title = 'Evacuation Map';

        $barangayModel = new BarangayPolygon();
        $barangayPolygons = [];
        try {
            $barangayPolygons = $barangayModel->getAllPolygons();
        } catch (\Exception $e) { }

        ob_start();
        include __DIR__ . '/../Views/evacuation/index.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }
}
