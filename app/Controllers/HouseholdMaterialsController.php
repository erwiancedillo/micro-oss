<?php

namespace App\Controllers;

use App\Models\HouseholdMaterials;

class HouseholdMaterialsController
{
    private $materialsModel;

    public function __construct()
    {
        $this->materialsModel = new HouseholdMaterials();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $is_logged_in = isset($_SESSION['user_id']);
        $is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

        $title = 'Household Materials Analysis';

        $materials = $this->materialsModel->getConstructionMaterials();
        $ownership = $this->materialsModel->getOwnershipTypes();
        $materials_total = $this->materialsModel->getMaterialsTotals();
        $ownership_total = $this->materialsModel->getOwnershipTotals();
        $most_common = $this->materialsModel->getMostCommonMaterial();
        $owned_count = $this->materialsModel->getOwnedHouseholdsCount();

        ob_start();
        include __DIR__ . '/../Views/household_materials.php';
        $content = ob_get_clean();

        include __DIR__ . '/../Views/layout.php';
    }

    public function updateMaterial()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error_message'] = "Unauthorized: Admin access required.";
            header("Location: /micro-oss/index.php?route=household-materials");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $materialName = $_POST['material_name'] ?? '';
            $households = (int)($_POST['households'] ?? 0);

            if ($this->materialsModel->updateMaterialHouseholds($materialName, $households)) {
                $_SESSION['success_message'] = "Construction material '$materialName' updated successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to update construction material.";
            }
        }

        header("Location: /micro-oss/index.php?route=household-materials");
        exit();
    }

    public function updateOwnership()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error_message'] = "Unauthorized: Admin access required.";
            header("Location: /micro-oss/index.php?route=household-materials");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ownershipType = $_POST['ownership_type'] ?? '';
            $households = (int)($_POST['households'] ?? 0);

            if ($this->materialsModel->updateOwnershipHouseholds($ownershipType, $households)) {
                $_SESSION['success_message'] = "Ownership type '$ownershipType' updated successfully!";
            } else {
                $_SESSION['error_message'] = "Failed to update ownership type.";
            }
        }

        header("Location: /micro-oss/index.php?route=household-materials");
        exit();
    }
}
