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
        echo json_encode(['success' => $success, 'message' => $success ? 'Saved' : 'Save failed']);
    } else {
        // Fallback for sitio or other types (legacy)
        echo json_encode(['success' => false, 'message' => 'Type not fully supported in MVC model yet']);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
