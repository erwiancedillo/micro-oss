<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../vendor/autoload.php';
use App\Models\BarangayAlert;

$name = $_GET['name'] ?? null;
if (!$name) {
    echo json_encode(['success' => false, 'message' => 'Missing barangay name']);
    exit;
}

try {
    $alertModel = new BarangayAlert();
    $data = $alertModel->getByName($name);
    
    if ($data) {
        // Parse WKT to Lat/Lng array
        $polygonWKT = $data['polygon'] ?? '';
        $coords = [];
        if (preg_match('/\(\((.*)\)\)/', $polygonWKT, $matches)) {
            $points = explode(',', $matches[1]);
            foreach ($points as $p) {
                $pair = preg_split('/\s+/', trim($p));
                if (count($pair) >= 2) {
                    $coords[] = ['lat' => floatval($pair[0]), 'lng' => floatval($pair[1])];
                }
            }
        }
        
        echo json_encode([
            'success' => true,
            'name' => $name,
            'polygon' => $coords
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Barangay not found']);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
