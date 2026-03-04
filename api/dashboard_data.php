<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../vendor/autoload.php';
use App\Models\EvacuationCenter;

try {
    $centerModel = new EvacuationCenter();
    $stats = $centerModel->getStats();
    $centers = $centerModel->getAll();

    $statusCount = ['Vacant' => 0, 'Limited' => 0, 'Full' => 0];
    foreach ($centers as $c) {
        $statusCount[$c['status']]++;
    }

    echo json_encode([
        'totalCenters' => (int)$stats['total_centers'],
        'totalCapacity' => (int)$stats['total_capacity'],
        'totalOccupied' => (int)$stats['total_occupied'],
        'centers' => $centers,
        'statusCount' => $statusCount
    ], JSON_PRETTY_PRINT);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}