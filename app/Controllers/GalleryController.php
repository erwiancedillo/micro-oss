<?php

namespace App\Controllers;

use App\Models\CitizenReport;
use App\Models\Database; // needed to fetch dynamic barangays

class GalleryController
{
    private $citizenModel;

    public function __construct()
    {
        $this->citizenModel = new CitizenReport();
    }

    public function index()
    {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Handle POST form submission for filters or fallback to empty strings
        $selectedBarangay = isset($_POST['barangay']) ? htmlspecialchars($_POST['barangay']) : '';
        $selectedSitio = isset($_POST['sitio']) ? htmlspecialchars($_POST['sitio']) : '';

        // Fetch Verified Citizen Science Reports with images
        $citizenReportsRaw = [];
        try {
            $citizenReportsRaw = $this->citizenModel->getAllReports();
        } catch (\Exception $e) {}
        
        $citizenPhotos = [];
        $isAdmin = (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin', 'master']));
        
        foreach ($citizenReportsRaw as $cr) {
            // Admins see all, users see only verified
            if ($cr['status'] === 'verified' || $isAdmin) {
                if (!empty($selectedBarangay) && strcasecmp($cr['barangay'], $selectedBarangay) !== 0) {
                    continue;
                }
                
                // Allow fuzzy search for sitio inside sitio and description fields
                if (!empty($selectedSitio)) {
                    $sitioMatch = (strpos(strtolower($cr['sitio'] ?? ''), strtolower($selectedSitio)) !== false);
                    $descMatch = (strpos(strtolower($cr['description'] ?? ''), strtolower($selectedSitio)) !== false);
                    if (!$sitioMatch && !$descMatch) {
                        continue;
                    }
                }
                $citizenPhotos[] = $cr;
            }
        }

        // Render view
        $title = 'Citizen Science';
        
        ob_start();
        include __DIR__ . '/../Views/gallery.php';
        $content = ob_get_clean();

        // Include unified layout
        include __DIR__ . '/../Views/layout.php';
    }

    public function uploadPhoto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $category = $_POST['category'] ?? '';
                if (empty($category)) {
                    $category = 'General Photo';
                }
                
                // Handle as Citizen Science Report
                $uploadDir = __DIR__ . '/../../assets/uploads/citizen_science/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = time() . '_' . basename($_FILES['photo']['name']);
                $targetFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                    if (session_status() === PHP_SESSION_NONE) session_start();
                    $data = [
                        'user_id' => $_SESSION['user_id'] ?? 1,
                        'category' => $category,
                        'description' => $_POST['description'] ?? '',
                        'latitude' => !empty($_POST['latitude']) ? $_POST['latitude'] : null,
                        'longitude' => !empty($_POST['longitude']) ? $_POST['longitude'] : null,
                        'barangay' => $_POST['barangay'] ?? '',
                        'sitio' => $_POST['sitio'] ?? '',
                        'image' => $fileName,
                        'status' => 'pending'
                    ];
                    $this->citizenModel->create($data);
                    $_SESSION['flash_message'] = "Photo submitted successfully! Admins will verify it.";
                } else {
                    if (session_status() === PHP_SESSION_NONE) session_start();
                    $_SESSION['error_message'] = "Error uploading photo.";
                }
            } else {
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['error_message'] = "Error uploading photo.";
            }
            
            header("Location: index.php?route=gallery");
            exit;
        }
    }

    public function editPhoto()
    {
        // Edit photo functionality moved to specialized tools or disabled
        header("Location: index.php?route=gallery");
        exit;
    }

    public function deletePhoto()
    {
        // Fallback or old routes points here
        header("Location: index.php?route=gallery");
        exit;
    }

    public function verifyCitizenReport()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array($_SESSION['role'] ?? '', ['admin', 'master'])) {
            header("Location: index.php?route=gallery");
            exit;
        }
        $id = $_GET['id'] ?? null;
        if ($id) {
            $citizenModel = new \App\Models\CitizenReport();
            $citizenModel->updateStatus($id, 'verified');
            $_SESSION['flash_message'] = 'Citizen Report verified successfully.';
        }
        header("Location: index.php?route=gallery");
        exit;
    }

    public function deleteCitizenReport()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array($_SESSION['role'] ?? '', ['admin', 'master'])) {
            header("Location: index.php?route=gallery");
            exit;
        }
        $id = $_GET['id'] ?? null;
        if ($id) {
            $citizenModel = new \App\Models\CitizenReport();
            $citizenModel->delete($id);
            $_SESSION['flash_message'] = 'Citizen Report deleted successfully.';
        }
        header("Location: index.php?route=gallery");
        exit;
    }

    public function getLocationsApi()
    {
        $action = $_GET['action'] ?? '';
        $db = \App\Models\Database::getInstance()->getConnection();
        header('Content-Type: application/json');

        if ($action === 'barangays') {
            $stmt = $db->query("SELECT DISTINCT name FROM barangay_polygons ORDER BY name ASC");
            $barangays = [];
            while ($row = $stmt->fetch()) {
                $barangays[] = $row['name'];
            }
            echo json_encode($barangays);
            exit;
        }

        if ($action === 'sitios') {
            $barangay = $_GET['barangay'] ?? '';
            $stmt = $db->prepare("SELECT DISTINCT sitio_name FROM sitios WHERE LOWER(barangay) = LOWER(?) ORDER BY sitio_name ASC");
            $stmt->execute([$barangay]);
            $sitios = [];
            while ($row = $stmt->fetch()) {
                $sitios[] = $row['sitio_name'];
            }
            echo json_encode($sitios);
            exit;
        }

        echo json_encode([]);
        exit;
    }
}
