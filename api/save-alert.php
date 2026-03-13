<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../vendor/autoload.php';
use App\Models\BarangayAlert;

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['type'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

try {
    $alertModel = new BarangayAlert();
    if ($data['type'] === 'barangay') {
        $success = $alertModel->save($data);
        echo json_encode(['success' => $success, 'message' => $success ? 'Barangay alert saved' : 'Save failed']);
    } elseif ($data['type'] === 'sitio') {
        $success = $alertModel->saveSitio($data);
        echo json_encode(['success' => $success, 'message' => $success ? 'Sitio alert saved' : 'Save failed']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid alert type']);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
