<?php

namespace App\Controllers;

use App\Models\GalleryModel;
use App\Models\Database; // needed to fetch dynamic barangays

class GalleryController
{
    private $galleryModel;

    public function __construct()
    {
        $this->galleryModel = new GalleryModel();
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

        // Fetch photos based on filters
        $photos = $this->galleryModel->getFilteredPhotos($selectedBarangay, $selectedSitio);

        // Render view
        $title = 'Community Gallery';
        
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
                // Ensure photo is an image and convert it to its binary form for BLOB
                $photoData = file_get_contents($_FILES['photo']['tmp_name']);
                
                $data = [
                    'barangay' => $_POST['barangay'] ?? '',
                    'sitio' => $_POST['sitio'] ?? '',
                    'description' => $_POST['description'] ?? '',
                    'latitude' => $_POST['latitude'] ?? null,
                    'longitude' => $_POST['longitude'] ?? null,
                    'photo' => $photoData
                ];

                $this->galleryModel->addPhoto($data);

                // Set flash message based on MVC pattern 
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['flash_message'] = "Photo uploaded successfully to the gallery!";
            } else {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['error_message'] = "Error uploading photo.";
            }
            
            // Redirect back to gallery
            header("Location: index.php?route=gallery");
            exit;
        }
    }

    public function editPhoto()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (($_SESSION['role'] ?? '') !== 'admin') {
            header("Location: index.php?route=gallery");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $data = [
                    'barangay' => $_POST['barangay'] ?? '',
                    'sitio' => $_POST['sitio'] ?? '',
                    'description' => $_POST['description'] ?? '',
                    'latitude' => $_POST['latitude'] ?? null,
                    'longitude' => $_POST['longitude'] ?? null,
                    'photo' => ''
                ];

                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $data['photo'] = file_get_contents($_FILES['photo']['tmp_name']);
                }

                $this->galleryModel->updatePhoto($id, $data);
                $_SESSION['flash_message'] = "Photo updated successfully!";
            } else {
                $_SESSION['error_message'] = "Error updating photo.";
            }
            header("Location: index.php?route=gallery");
            exit;
        }
    }

    public function deletePhoto()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (($_SESSION['role'] ?? '') !== 'admin') {
            header("Location: index.php?route=gallery");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->galleryModel->deletePhoto($id);
            $_SESSION['flash_message'] = "Photo deleted successfully.";
        } else {
            $_SESSION['error_message'] = "Error deleting photo.";
        }
        header("Location: index.php?route=gallery");
        exit;
    }

    // API endpoint for fetching locations
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
