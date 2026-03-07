<?php

namespace App\Controllers;

use App\Models\AgePopulation;

class SocioController
{
    private $agePopulationModel;

    public function __construct()
    {
        $this->agePopulationModel = new AgePopulation();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /micro-oss/index.php?route=login');
            exit();
        }

        $is_logged_in = true;
        $user_role = $_SESSION['role'] ?? null;
        $is_admin = $user_role === 'admin';

        $agePopulation = $this->agePopulationModel->getAll();
        $totals = $this->agePopulationModel->getTotals();
        $ageGroups = $this->agePopulationModel->getAgeGroups();

        $title = 'Population Demographics';

        ob_start();
        include __DIR__ . '/../Views/socio.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layout.php';
    }

    public function addAgeBracket()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_SESSION['role'] ?? '') === 'admin') {
            $female = (int)$_POST['female'];
            $male = (int)$_POST['male'];
            $data = [
                'age_bracket' => $_POST['age_bracket'],
                'female' => $female,
                'male' => $male,
                'total' => $female + $male
            ];

            $this->agePopulationModel->create($data);
            $_SESSION['flash_message'] = 'Age bracket added successfully.';
            header('Location: /micro-oss/index.php?route=socio');
            exit();
        }
    }
}
