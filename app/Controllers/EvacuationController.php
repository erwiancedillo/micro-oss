<?php

namespace App\Controllers;

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
        ob_start();
        include __DIR__ . '/../Views/evacuation/index.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }
}
