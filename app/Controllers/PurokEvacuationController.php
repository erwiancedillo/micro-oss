<?php

namespace App\Controllers;

use App\Models\PurokEvacuation;

class PurokEvacuationController
{
    private $evacuationModel;

    public function __construct()
    {
        $this->evacuationModel = new PurokEvacuation();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $is_logged_in = isset($_SESSION['user_id']);
        $is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

        $title = 'Purok Evacuation';

        $data = $this->evacuationModel->getAllData();

        ob_start();
        include __DIR__ . '/../Views/purok_evacuation.php';
        $content = ob_get_clean();

        include __DIR__ . '/../Views/layout.php';
    }
}
