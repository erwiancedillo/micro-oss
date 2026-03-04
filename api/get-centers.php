<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../vendor/autoload.php';
use App\Models\EvacuationCenter;

try {
    $centerModel = new EvacuationCenter();
    $data = $centerModel->getAll();
    echo json_encode($data, JSON_PRETTY_PRINT);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}