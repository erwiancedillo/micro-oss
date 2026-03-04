<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../vendor/autoload.php';
use App\Models\EvacuationCenter;

$data = json_decode(file_get_contents('php://input'), true);
if (!$data || !isset($data['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing ID']);
    exit;
}

try {
    $centerModel = new EvacuationCenter();
    $success = $centerModel->delete((int)$data['id']);
    echo json_encode(['success' => $success]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}